<?php

namespace App\Http\Controllers\frontend;

use App\Models\Review;
use App\Http\Controllers\Controller;
use App\Models\Product;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Product::with('category');
    
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->input('search');
        
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhereHas('category', function ($catQuery) use ($search) {
                      $catQuery->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }
    
        // Fetch the results with applied search (do not overwrite)
        $products = $query->get();
    
        // Optionally, handle the cart here
        // $cart = session()->get('cart', []);
    
        return view('frontend.products.index', compact('products'));
    }
    
    
    
   
    public function show($product_id)
    {
        $product = Product::findOrFail($product_id);
        $reviews = $product->reviews()->with('user')->latest()->get();

        return view('frontend.products.show', compact('product', 'reviews'));
    }

}
