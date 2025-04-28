@extends('frontend.layout.master')

@section('content')
    <div class="container my-5 text-center">
        <div class="card shadow-sm p-5">
            <h1 class="text-success mb-4">🎉 Booking Successful!</h1>
            <p class="lead">Thank you for your Booking.</p>
            
            <div class="my-4">
                <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
                @if($booking)
                <a href="{{ route('booking.show', $booking->id) }}"class="btn btn-outline-secondary" >
                    View My Bookings
                </a>
            @endif
            </div>
        </div>
    </div>
@endsection