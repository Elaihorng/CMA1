<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Intervention\Image\Laravel\Facades\Image;
use App\Models\Category;

class BProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('backend.product.index')->with('products',$products);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $categories = Category::all();  // Retrieve categories
        return view('backend.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:products|max:100',
            'category_id' => 'required|exists:category,id',

            'price' => 'required',
            'stock_quantity' => 'required',
        ], [
            'name.required' => 'Please Enter product name',
            'name.max' => 'Product name can only be 50 characters long',
        ]);

        $input = $request->all();

        if ($request->hasFile('image_url')) {
            $image_file = $request->file('image_url');
            $file_name = time() . '.' . $image_file->getClientOriginalExtension();
            $thumbnailPath = public_path('/uploads/thumbnail/product');
            $imgFile = image::read($image_file->getRealPath());
            $imgFile->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumbnailPath . '/' . $file_name);
            $destinationPath = public_path('/uploads/product');
            $image_file->move($destinationPath, $file_name);
            $input['image_url'] = $file_name;
        }
        Product::create($input,$validated); 

        return redirect('/product')->with('alert_messsage','Product Added!<3');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('backend.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $product_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|unique:products,name,' . $product->product_id.',product_id|max:50',
            'category_id' => 'required|exists:category,id',
            'price' => 'required',
            'stock_quantity' => 'required',
        ], [
            'name.required' => 'Please Enter product name',
            'name.max' => 'Product name can only be 50 characters long',
        ]);

         $products = Product::findOrFail($product->product_id );
         
         $input = $request->all();
         
         if ($request->hasFile('image_url')) {
             
             if ($products->image_url) {
                 $oldImagePath = public_path('/uploads/product/' . $products->image_url);
                 $oldThumbnailPath = public_path('/uploads/thumbnail/product/' . $products->image_url);
 
                 if (file_exists($oldImagePath)) {
                     unlink($oldImagePath);
                 }
                 if (file_exists($oldThumbnailPath)) {
                     unlink($oldThumbnailPath);
                 }
             }
 
             
             $image_file = $request->file('image_url');
             $file_name = time() . '.' . $image_file->getClientOriginalExtension();
 
             $thumbnailPath = public_path('/uploads/thumbnail/product');
             $imgFile = Image::read($image_file->getRealPath());
             $imgFile->resize(150, 150, function ($constraint) {
                 $constraint->aspectRatio();
             })->save($thumbnailPath . '/' . $file_name);
 
             $destinationPath = public_path('/uploads/product');
             $image_file->move($destinationPath, $file_name);
 
            
             $input['image_url'] = $file_name;
         } else {
             
             $input['image_url'] = $products->image_url;
         }
         
         if ($products->update($input)) {
             
             return redirect()->route('product.index')->with('alert_messsage', 'Product updated successfully! <3');
             
 
         }
        
         return redirect()->back()->withErrors(['Something went wrong. Please try again!']);
    }
    public function showReviews($product_id)
    {
        // Get the product
        $product = Product::findOrFail($product_id);

        // Get the reviews related to this product
        $reviews = $product->reviews()->with('user')->get();

        // Return the reviews view with the product and reviews data
        return view('backend.product.reviews', compact('product', 'reviews'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        if ($product->image_url) {
            $imagePath = public_path('/uploads/product/' . $product->image_url);
            $thumbnailPath = public_path('/uploads/thumbnail/product/' . $product->image_url);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            if (file_exists($thumbnailPath)) {
                unlink($thumbnailPath);
            }
        }

        $product->delete();
        return response()->json(['success' => true]);
    }
}
