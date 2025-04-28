@extends('frontend.layout.master')
@section('title', 'Products')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Product Listing</h1>
    <div class="row">
        @foreach ($products as $product)
        <div class="card">
            <img src="{{ asset('storage/' . ($product->image ?: 'default-image.jpg')) }}" class="card-img-top" alt="{{ $product->name }}">
            <div class="card-body">
                
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text">{{ Str::limit($product->description, 100, '...') }}</p>
                <p class="card-text"><strong>Price:</strong> ${{ $product->price }}</p>
                <a href="{{ route('products.show', $product->product_id) }}" 
                class="btn btn-primary">View Product Details</a>
            </div>
        </div>
    @endforeach
        </div>
</div>
@endsection
