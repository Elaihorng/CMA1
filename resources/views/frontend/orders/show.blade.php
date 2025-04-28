@extends('frontend.layout.master')

@section('content')
<div class="container">
    <a href="{{ route('frontend.orders.index') }}" class="btn btn-primary py-3 px-5">Back <i class="fa fa-arrow-left ms-3"></i></a>
    <h1 class="text-center my-4">Order Details</h1>
    
    <div class="mb-3">
        <strong>Order Number:</strong> {{ $order->order_number }}
    </div>
    <div class="mb-3">
        <strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}
    </div>
    <div class="mb-3">
        <strong>Delivery Method:</strong> {{ ucfirst($order->shipping_method) }}
    </div>
    <div class="mb-3">
        <strong>Status:</strong> {{ ucfirst($order->status) }}
    </div>
    <div class="mb-3">
        <strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}
    </div>

    <h4>Order Items:</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
                <tr>
                    <td>
                        <img src="{{ asset('/uploads/product/'. $item->product->image_url) }}" width="50" alt="{{ $item->product->name }}">
                    </td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
