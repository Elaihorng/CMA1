@extends('frontend.layout.master')

@section('content')
<div class="container mt-4">


    <h2 class="text-center">Booking Details</h2>

    <div class="card mb-4">
        <div class="card-body">
            <h4 class="mt-4">Booking #{{ $booking->id }}</h4>
            <p><strong>Name:</strong> {{ $booking->name }}</p>
            <p><strong>Service Date:</strong> {{ $booking->service_date }}</p>
            <p><strong>Email:</strong> {{ $booking->email }}</p>
            <p><strong>Request:</strong> {{ $booking->request ?? '-' }}</p>
            <p><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>
        </div>
        @if($booking)
            <a href="{{ route('booking.show', $booking->id) }}" class="btn btn-outline-secondary">
                Back
            </a>
        @endif
    
    </div>

    <hr>
</div>
@endsection
