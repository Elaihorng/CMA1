@extends('frontend.layout.master')

@section('title', 'booking')
@section('content')

<!-- Booking Start -->
<div class="container-fluid bg-secondary booking my-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="row gx-5">
            <div class="col-lg-6 py-5">
                <div class="py-5">
                    <h1 class="text-white mb-4">Certified and Award Winning Computer Repair Service Provider</h1>
                    <p class="text-white mb-0">Eirmod sed tempor lorem ut dolores. Aliquyam sit sadipscing kasd ipsum. Dolor ea et dolore et at sea ea at dolor, justo ipsum duo rebum sea invidunt voluptua. Eos vero eos vero ea et dolore eirmod et. Dolores diam duo invidunt lorem. Elitr ut dolores magna sit. Sea dolore sanctus sed et. Takimata takimata sanctus sed.</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="bg-primary h-100 d-flex flex-column justify-content-center text-center p-5 wow zoomIn" data-wow-delay="0.6s">
                    <h1 class="text-white mb-4">Book For A Service</h1>
                    @component('components.alert')
              
                    @endcomponent
                    <form action="{{ route('booking.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <input type="text" name="name" class="form-control border-0" placeholder="Your Name" style="height: 55px;" required>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="date" id="date1" data-target-input="nearest">
                                    <input type="text"
                                        name="service_date"
                                        class="form-control border-0 datetimepicker-input"
                                        placeholder="Service Date" data-target="#date1" data-toggle="datetimepicker" style="height: 55px;" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <input type="email" name="email" class="form-control border-0" placeholder="Your Email" style="height: 55px;" required>
                            </div>
                            <div class="col-12">
                                <textarea name="request" class="form-control border-0" placeholder="Special Request"></textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-secondary w-100 py-3" type="submit">Book Now</button>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Booking End -->



@endsection