<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // Fetch only orders for the logged-in user, with related items
        $orders = Order::with('items')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
    
        return view('frontend.orders.index', compact('orders'));
    }
    
    public function show($id)
    {
        // Your logic here, like fetching the order from the database
        $order = Order::findOrFail($id);
        return view('frontend.orders.show', compact('order'));
    }


}

