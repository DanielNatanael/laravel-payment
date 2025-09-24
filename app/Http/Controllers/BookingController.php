<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        return view('booking.index');
    }

    public function success($booking_code)
    {
        $booking = Booking::with('bookingItems.ticket')
            ->where('booking_code', $booking_code)
            ->firstOrFail();

        return view('booking.success', compact('booking'));
    }

    public function check($booking_code)
    {
        $booking = Booking::with('bookingItems.ticket')
            ->where('booking_code', $booking_code)
            ->firstOrFail();

        return view('booking.check', compact('booking'));
    }
}