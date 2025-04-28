@extends('frontend.layout.master')

@section('content')
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h2>Hello, {{ Auth::user()->name }} 👋</h2>
    <hr>

    <h4>Your Booking History</h4>
    @if($allBookings->count())
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Service Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allBookings as $b)
                <tr>
                    <td>{{ $b->id }}</td>
                    <td>{{ $b->service_date }}</td>
                    <td>{{ ucfirst($b->status) }}</td>
                    <td>
                        <a href="{{ route('booking.details', $b->id) }}" class="btn btn-sm btn-primary">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No booking history available.</p>
    @endif
</div>
@endsection
