<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\PaywayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;  // Make sure you have this if you want to fetch orders from DB

class PaywayController extends Controller
{
    protected $paywayService;

    public function __construct(PaywayService $paywayService)
    {
        $this->paywayService = $paywayService;
    }

    public function pay(Request $request)
    {
        // Assuming you get the order from the database, for example:
        $order = Order::find($request->input('order_id')); // Adjust based on your request input
        
        if (!$order) {
            \Log::error('Order not found', ['order_id' => $request->input('order_id')]);
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Generate a unique transaction ID
        $transactionId = uniqid('tran_');

        // Payment data for PayWay API
        $paymentData = [
            'merchant_id'    => config('payway.merchant_id'),
            'amount'         => $order->total_amount * 100, // Convert to cents
            'description'    => 'Payment for Order #' . $order->id,
            'return_url'     => route('payway.success'),
            'cancel_url'     => route('payway.cancel'),
            'order_id'       => $order->id,
            'customer_name'  => $order->customer_name,
            'customer_email' => $order->customer_email,
            'first_name'     => $order->customer_first_name, // Adjust field names based on your DB
            'last_name'      => $order->customer_last_name,  // Adjust field names based on your DB
            'phone'          => $order->customer_phone,      // Adjust field names based on your DB
            'currency'       => 'USD', // Adjust currency as needed
        ];
    
        Log::info('Sending payment request', ['paymentData' => $paymentData]);
    
        $response = $this->paywayService->createTransaction($paymentData);
    
        if (isset($response['error'])) {
            Log::error('Payment request failed', ['error' => $response['error']]);
            return response()->json(['message' => 'Payment failed', 'error' => $response['error']], 500);
        }
    
        // If the response contains raw HTML for redirection
        if (isset($response['html'])) {
            return response($response['html'])->header('Content-Type', 'text/html');
        }

        // Fallback: unexpected response
        return response()->json([
            'message' => 'Unexpected response format from PayWay.',
            'transactionId' => $transactionId,
            'response' => $response,
        ]);
    }

    public function paymentSuccess(Request $request)
    {
        // Here you can verify the payment and mark the order as successful in DB if needed
        Log::info('Payment successful', ['request_data' => $request->all()]);
        return response()->json([
            'message' => 'Payment successful!',
            'request_data' => $request->all(),
        ]);
    }

    public function paymentCancel(Request $request)
    {
        // Log the cancellation and handle any necessary actions (e.g., refund, mark as canceled)
        Log::info('Payment cancelled', ['request_data' => $request->all()]);
        return response()->json([
            'message' => 'Payment cancelled!',
            'request_data' => $request->all(),
        ]);
    }
}
