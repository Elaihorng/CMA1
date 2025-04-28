<?php

namespace App\Http\Controllers\backend;

use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Mail\BookingConfirmedMail;

use Illuminate\Http\Request;
use App\Models\Booking;
class BBookingController extends Controller
{
    public function index()
    {
        $booking = Booking::all();
        return view('backend.booking.index')->with('booking',$booking);
    }
    public function confirm($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'confirmed';
        $booking->save();
        Mail::to($booking->email)->send(new BookingConfirmedMail($booking));
        return redirect()->back()->with('success', 'Booking confirmed successfully!');
    }
    public function show($id)
    {
        // Find the booking by its ID
        $booking = Booking::findOrFail($id);

        // Return the view with booking details
        return view('backend.booking.show', compact('booking'));
    }


}
