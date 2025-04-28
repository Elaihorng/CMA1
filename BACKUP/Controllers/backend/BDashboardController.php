<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class BDashboardController extends Controller
{
    public function index(){
        return view ('backend.dashboard.index');
    }


    public function products()
    {
        $products = Product::all();
        return view('backend.products.index', compact('products'));
    }

    public function create()
    {
        return view('backend.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'stock_quantity' => 'nullable|integer|min:0',
            'image_url' => 'nullable|string|max:255',
        ]);
    
        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'category' => $request->category,
            'stock_quantity' => $request->stock_quantity,
            'image_url' => $request->image_url,
        ]);
    
        return redirect()->route('admin.products')->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('backend.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'stock_quantity' => 'required|integer|min:0',
            'image_url' => 'nullable|file|image|max:2048', // Image validation
        ]);
    
        $product = Product::findOrFail($id);
    
        // Update product fields
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->category = $request->category;
        $product->stock_quantity = $request->stock_quantity;
    
        // Handle image upload
        if ($request->hasFile('image_url')) {
            // Delete old image if it exists
            if ($product->image_url && \Storage::exists('public/' . $product->image_url)) {
                \Storage::delete('public/' . $product->image_url);
            }
    
            // Save new image
            $product->image_url = $request->file('image_url')->store('product_images', 'public');
        }
    
        $product->save();
    
        return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        Product::destroy($id);
        return redirect()->route('admin.products')->with('success', 'Product deleted successfully!');
    }

    public function orders()
    {
        $orders = Order::all();
        return view('backend.orders.index', compact('orders'));
    }
    
}
