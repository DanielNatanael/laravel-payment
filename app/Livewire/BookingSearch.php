<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking;

class BookingSearch extends Component
{
    public $booking_code = '';
    public $booking = null;
    public $error = '';

    public function search()
    {
        $this->error = '';
        $this->booking = null;

        if (empty($this->booking_code)) {
            $this->error = 'Masukkan kode booking';
            return;
        }

        $this->booking = Booking::with('bookingItems.ticket')
            ->where('booking_code', $this->booking_code)
            ->first();

        if (!$this->booking) {
            $this->error = 'Kode booking tidak ditemukan';
        }
    }

    public function render()
    {
        return view('livewire.booking-search');
    }
}