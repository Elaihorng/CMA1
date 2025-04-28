@extends('frontend.layout.master')

@section('content')
<div class="container">
    <a href="{{ url('/') }}" class="btn btn-primary py-3 px-5">Back <i class="fa fa-arrow-left ms-3"></i></a>
    <h1 class="text-center my-4">Your Orders</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(count($orders) > 0)
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order Number</th>
                <th>Item</th>
                <th>Total Amount</th>
                <th>Delivery Method</th>
                <th>Status</th>
                <th>Payment Status</th>
                <th>Order Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <!-- Order Number -->
                    <td>{{ $order->order_number }}</td>
                    <td>
                        @foreach ($order->orderItems as $item)
                            {{ $item->product->name }}@if (!$loop->last), @endif
                        @endforeach
                    </td>
                    <!-- Total Amount -->
                    <td>${{ number_format($order->total_amount, 2) }}</td>
    
                    <!-- Delivery Method (Shipping Method) -->
                    <td>{{ ucfirst($order->shipping_method) }}</td>
    
                    <!-- Order Status -->
                    <td>{{ ucfirst($order->status) }}</td>
    
                    <!-- Payment Status -->
                    <td>{{ ucfirst($order->payment_status) }}</td>
    
                    <!-- Order Date -->
                    <td>{{ $order->order_date->format('Y-m-d H:i:s') }}</td>
    
                    <!-- Actions (e.g., View, Cancel, etc.) -->
                    <td>
                        <a href="{{ route('frontend.orders.show', $order->id) }}" class="btn btn-info btn-sm">View</a>
                        <!-- You can add more actions like cancel order, etc. -->
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    @else
        <p class="text-center">You have no orders yet.</p>
    @endif
</div>
@endsection