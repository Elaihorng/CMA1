<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmedMail;
use App\Services\MailSlurpService;
use App\Services\PaywayService;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Customer;
use Exception;

class CheckoutController extends Controller
{
    public function index()
    {
        // Your logic here
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('frontend.cart.index')->with('error', 'Your cart is empty!');
        }

        // Calculate total price
        $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        return view('frontend.checkout.index', compact('cart', 'total'));
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('frontend.cart.index')->with('error', 'Your cart is empty!');
        }
    
        $validatedData = $request->validate([
            'shipping_address' => 'required|string|max:255',
            'shipping_method' => 'required|in:pickup,shipping',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'order_notes' => 'nullable|string|max:255',
            'payment_method' => 'required|in:STRIPE,CASH,ABA_CARD',
        ]);
    
        $shippingMethod = $validatedData['shipping_method'];
        $shippingFee = ($shippingMethod === 'shipping') ? 5 : 0;
    
        $total = array_sum(array_map(function ($item) {
            return floatval($item['price']) * $item['quantity'];
        }, $cart)) + $shippingFee;
    
        $orderNumber = 'ORD-' . Str::upper(Str::random(10));
    
        try {
            // Create the order and associate it with the authenticated user (user_id)
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => auth()->check() ? auth()->id() : null, // Associating the user
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'shipping_method' => $shippingMethod,
                'shipping_address' => $validatedData['shipping_address'],
                'payment_method' => $validatedData['payment_method'],
                'total_amount' => $total,
                'status' => 'pending',
                'payment_status' => 'pending',
                'order_notes' => $validatedData['order_notes'],
                'order_date' => now(),
            ]);
    
            // Save the order items (same as before)
            foreach ($cart as $productId => $item) {
                // Create the order item
                $order->items()->create([
                    'order_id'     => $order->id,
                    'product_id'   => $productId,
                    'product_name' => $item['name'],
                    'quantity'     => $item['quantity'],
                    'price'        => $item['price'],
                ]);
    
                // Decrease the product stock after the order item is added
                $product = Product::find($productId);
                if ($product) {
                    $product->stock_quantity -= $item['quantity'];
                    $product->save();  // Save the updated product stock
                }
            }
    
            // Clear the cart before redirect
            session()->forget('cart');
    
            Log::info('Order created', ['order_id' => $order->id]);
    
            // Handle STRIPE payment method
            if ($request->payment_method === 'STRIPE') {
                Stripe::setApiKey(env('STRIPE_SECRET'));
        
                $amount = (int) $request->grand_total * 100; // convert to cents
        
                try {
                    // Create the PaymentIntent
                    $paymentIntent = PaymentIntent::create([
                        'amount' => $amount,
                        'currency' => 'usd',
                        'payment_method_types' => ['card'],
                        'description' => 'Order payment',
                    ]);
            
                    // Update the order status and payment status
                    $order->payment_status = 'paid';
                    $order->status = 'confirmed';
                    $order->save();
            
                    // Send the confirmation email
                    Mail::to($order->email)->send(new OrderConfirmedMail($order));
            
                    return response()->json([
                        'clientSecret' => $paymentIntent->client_secret,
                        'order_id' => $order->id,
                    ]);
                    
                } catch (\Exception $e) {
                    // Handle any errors
                    return response()->json(['error' => $e->getMessage()], 500);
                }
                
            }

            // Handle CASH payment method
            if ($validatedData['payment_method'] === 'CASH') {
                $order->status = 'confirmed';
                $order->save();
                Mail::to($order->email)->send(new OrderConfirmedMail($order));
                return redirect()->route('frontend.orders.index')->with('success', 'Order placed successfully!');
            }
    
        } catch (Exception $e) {
            Log::error('Order creation failed', ['error' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('error', 'Failed to place order. Please try again.');
        }
    }


}
