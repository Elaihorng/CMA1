<?php

namespace App\Http\Controllers\backend;

use App\Models\Product;
use App\Models\Stock;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BStockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with('product')->latest()->get();
        $products = Product::all();
        return view('backend.stocks.index', compact('stocks', 'products'));
        
    }

    public function stockIn(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $product->stock_quantity += $request->quantity;
        $product->save();

        Stock::create([
            'product_id' => $product->product_id,
            'type' => 'in',
            'quantity' => $request->quantity,
            'note' => $request->note,
        ]);

        return back()->with('success', 'Stock added successfully.');
    }

    public function stockOut(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock_quantity < $request->quantity) {
            return back()->with('error', 'Not enough stock.');
        }

        $product->stock_quantity -= $request->quantity;
        $product->save();

        Stock::create([
            'product_id' => $product->product_id,
            'type' => 'out',
            'quantity' => $request->quantity,
            'note' => $request->note,
        ]);

        return back()->with('success', 'Stock removed successfully.');
    }
    public function history()
    {
        $stocks = Stock::with('product')->latest()->get();
        return view('backend.stocks.history', compact('stocks'));
    }

}
