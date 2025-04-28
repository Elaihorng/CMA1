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

    $cart = session()->get('cart', []);

    // Check if the product is already in the cart
    if (isset($cart[$product_id])) {
        $cart[$product_id]['quantity']++;
    } else {
        $cart[$product_id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "image" => $product->image ?? 'Zebbook.png',  // Ensure you're using image_url
        ];
    }

    session()->put('cart', $cart);  // Update the session cart

    // Debugging: Check the cart content after the update
    dd(session()->get('cart'));  // Dump the session cart data

    return redirect()->route('frontend.cart.index')->with('success', 'Product added to cart!');
}

}


