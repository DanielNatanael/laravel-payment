<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Ticket;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $tickets = Ticket::all();
        
        // Sample booking 1
        $booking1 = Booking::create([
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'customer_phone' => '081234567890',
            'visit_date' => now()->addDays(2),
            'visit_time' => '09:00',
            'total_amount' => 50000,
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'notes' => 'Kunjungan keluarga',
        ]);

        // Booking items untuk booking 1
        BookingItem::create([
            'booking_id' => $booking1->id,
            'ticket_id' => $tickets->where('name', 'Tiket Dewasa')->first()->id,
            'quantity' => 2,
            'price' => 15000,
            'subtotal' => 30000,
        ]);

        BookingItem::create([
            'booking_id' => $booking1->id,
            'ticket_id' => $tickets->where('name', 'Tiket Anak')->first()->id,
            'quantity' => 2,
            'price' => 10000,
            'subtotal' => 20000,
        ]);

        // Sample booking 2
        $booking2 = Booking::create([
            'customer_name' => 'Jane Smith',
            'customer_email' => 'jane@example.com',
            'customer_phone' => '082345678901',
            'visit_date' => now()->addDays(5),
            'visit_time' => '14:00',
            'total_amount' => 15000,
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);

        BookingItem::create([
            'booking_id' => $booking2->id,
            'ticket_id' => $tickets->where('name', 'Tiket Dewasa')->first()->id,
            'quantity' => 1,
            'price' => 15000,
            'subtotal' => 15000,
        ]);
    }
}