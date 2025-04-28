@extends('frontend.layout.master')

@section('content')
    <div class="container my-5 text-center">
        <div class="card shadow-sm p-5">
            <h1 class="text-success mb-4">🎉 Payment Successful!</h1>
            <p class="lead">Thank you for your order.</p>
            <p>Your payment has been processed successfully.</p>
            
            <div class="my-4">
                <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
                <a href="{{url('/orders')}}" class="btn btn-outline-secondary">View My Orders</a>
            </div>
        </div>
    </div>
@endsection
