<?php

namespace App\Http\Controllers\frontend;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {   
        return view('frontend.booking.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'service_date' => 'required|date',
            'email' => 'required|email',
            'request' => 'nullable|string'
        ]);

        $booking = new Booking();
        $booking->user_id = Auth::id(); 
        $booking->name = $request->input('name');
        $booking->service_date = date('Y-m-d', strtotime($request->input('service_date')));
        $booking->email = $request->input('email');
        $booking->request = $request->input('request');
        $booking->status = 'pending';  
        $booking->save();

    return redirect()->route('booking.success', $booking->id)->with('success', 'Booking successful!')->with('booking', $booking);
        
    }
    public function success()
    {
        $user = Auth::user();
        $booking = $user->bookings()->latest()->first();
        return view('frontend.booking.success', compact('booking'));
    }
    public function show($id)
    {
        $user = Auth::user();
    
        // Get the booking by ID that belongs to the authenticated user
        $booking = $user->bookings()->where('id', $id)->firstOrFail();
    
        // Get all bookings for history
        $allBookings = $user->bookings()->orderBy('created_at', 'desc')->get();
    
        return view('frontend.booking.show', compact('booking', 'allBookings'));
    }
    public function details($id)
    {
        $user = Auth::user(); // Get the authenticated user
        $booking = $user->bookings()->find($id); // Find the booking by ID for the authenticated user

        if (!$booking) {
            return redirect()->route('booking.index')->with('error', 'Booking not found!');
        }

        return view('frontend.booking.bookingDetails', compact('booking')); // Pass the booking data to the view
    }

    

}
