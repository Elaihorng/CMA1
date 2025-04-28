<?php

namespace App\Http\Controllers\backend;

use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmedMail;
use App\Mail\OrderCancelledMail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
class BOrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('backend.orderPlace.index', compact('orders'));
    }
    public function show($id)
    {
        $orders = Order::findOrFail($id); // Find order by ID or fail
        return view('backend.orderPlace.show', compact('orders')); // Pass the order to a show view
    }
    public function confirm($id)
    {
        $order = Order::findOrFail($id);
        $order->payment_status = 'paid';
        $order->status = 'confirmed';
        $order->save();

        Mail::to($order->email)->send(new OrderConfirmedMail($order));

        return redirect()->back()->with('success', 'Order confirmed and email sent!');
    }

    public function cancel($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'cancelled';
        $order->save();

        Mail::to($order->email)->send(new OrderCancelledMail($order));

        return redirect()->back()->with('success', 'Order cancelled and email sent!');
    }
    public function markAsPaid(Order $order)
    {
        if ($order->payment_method === 'CASH' && $order->payment_status !== 'paid') {
            $order->payment_status = 'paid';  // Update payment status
            $order->save();
            return redirect()->route('orderPlace.index')->with('success', 'Order marked as paid!');
        }
    
        return redirect()->route('orderPlace.index')->with('error', 'Unable to mark as paid.');
    }
    

}
