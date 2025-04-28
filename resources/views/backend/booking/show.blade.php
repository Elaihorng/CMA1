@extends('backend.layout.master')
@section('title', 'Booking Details')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1 class="text-primary">Read Booking</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Read Booking</h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.bookings.index') }}" class="btn btn-tool" title="Back">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="mailbox-read-info">
                                <h5>Booking for: {{ $booking->name }}</h5>
                                <h6>
                                    From: {{ $booking->email }}
                                    <span class="mailbox-read-time float-right">
                                        {{ \Carbon\Carbon::parse($booking->service_date)->format('d M, Y') }}
                                    </span>
                                </h6>
                            </div>

                            <div class="mailbox-controls with-border text-left mb-3">
                              <p><strong>Special Request:</strong></p>
                                <div class="btn-group">
                                  
                                  <p>{{ $booking->request ?? 'None' }}</p>
                                </div>
                            </div>

                            <div class="mailbox-read-message">
                                <p><strong>Status:</strong>
                                    <span class="badge {{ $booking->status === 'confirmed' ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </p>

                                
                               
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="float-right">
                                <a href="#" class="btn btn-default"><i class="fas fa-share"></i> Forward</a>
                            </div>
                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-default"><i class="fas fa-arrow-left"></i> Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
