<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;



class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []); // Fetch cart from session
        return view('frontend.cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $product_id = $request->input('product_id');
        $product = Product::findOrFail($product_id);
    
        // Get the quantity from the form, default to 1 if not provided
        $quantity = $request->input('quantity', 1);
    
        // Get the current cart from session
        $cart = session()->get('cart', []);
    
        // Check if the product is already in the cart
        if (isset($cart[$product_id])) {
            // If the product is already in the cart, increase its quantity
            $cart[$product_id]['quantity'] += $quantity;
        } else {
            // Otherwise, add the product to the cart with product_id
            $cart[$product_id] = [
                'product_id' => $product_id,  // Explicitly store the product_id here
                'name' => $product->name,
                'quantity' => $quantity,
                'price' => $product->price,
                'image_url' => $product->image_url ?? 'default-image.jpg'  // Ensure fallback to default if null
            ];
        }
    
        // Save the updated cart back to the session
        session()->put('cart', $cart);
    
        // Redirect back with success message
        return back()->with('success', 'Product added to cart successfully!');
    }
    

    public function update(Request $request, $product_id)
    { 
        


        $cart = session()->get('cart', []);
    
        if (isset($cart[$product_id])) {
            $cart[$product_id]['quantity'] = $request->input('quantity'); 
            session()->put('cart', $cart); 
            return redirect()->route('frontend.cart.index')->with('success', 'Cart updated successfully!');
        }
    
        return redirect()->route('frontend.cart.index')->with('error', 'Product not found in cart!');
    }
    
   

    public function remove($id) // Use $id instead of $product_id
{
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        unset($cart[$id]);
        session()->put('cart', $cart);
    }

    return redirect()->route('frontend.cart.index')->with('success', 'Product removed!');
}
    
}