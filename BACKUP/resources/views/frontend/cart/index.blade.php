@extends('frontend.layout.master')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Shopping Cart</h1>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(count($cart) > 0)
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
            @foreach ($cart as $product)
            <tr>
                <td><img src="{{ asset('storage/' . $item['image']) }}" width="50" alt="{{ $item['name'] }}"></td>
                <td>{{ $item['name'] }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>${{ $item['price'] }}</td>
                <td>${{ $item['price'] * $item['quantity'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>Your cart is empty.</p>
    @endif
</div>
@endsection
