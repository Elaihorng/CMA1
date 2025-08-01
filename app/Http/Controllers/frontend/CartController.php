<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;



class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        return view('frontend.cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity', 1); // default to 1
    
        $product = Product::findOrFail($product_id);
    
        // Get current cart
        $cart = session()->get('cart', []);
    
        // Calculate the total quantity in cart after this addition
        $existingQty = isset($cart[$product_id]) ? $cart[$product_id]['quantity'] : 0;
        $newTotalQty = $existingQty + $quantity;
    
        // Check stock availability
        if ($newTotalQty > $product->stock_quantity) {
            return back()->with('error', 'Not enough stock available!');
        }
    
        // Add or update cart
        if (isset($cart[$product_id])) {
            $cart[$product_id]['quantity'] = $newTotalQty;
        } else {
            $cart[$product_id] = [
                'product_id' => $product_id,
                'name' => $product->name,
                'quantity' => $quantity,
                'price' => $product->price,
                'image_url' => $product->image_url ?? 'default-image.jpg',
            ];
        }
    
        session()->put('cart', $cart);
    
        return back()->with('success', 'Product added to cart successfully!');
    }
    
    

    public function update(Request $request, $product_id)
    { 
        
        $product = Product::findOrFail($product_id);
        if ($request->quantity > $product->stock_quantity) {
            return redirect()->back()->with('error', 'Not enough stock available.');
        }


        $cart = session()->get('cart', []);
    
        if (isset($cart[$product_id])) {
            $cart[$product_id]['quantity'] = $request->input('quantity'); 
            session()->put('cart', $cart); 
            return redirect()->route('frontend.cart.index')->with('success', 'Cart updated successfully!');
        }
    
        return redirect()->route('frontend.cart.index')->with('error', 'Product not found in cart!');
    }
    
    public function checkStock(Request $request)
    {
        $product = Product::find($request->product_id);
    
        if ($product) {
            $stockAvailable = $product->stock_quantity >= $request->quantity;
            return response()->json(['stock_available' => $stockAvailable]);
        }
    
        return response()->json(['stock_available' => false]);
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