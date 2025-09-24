<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $tickets = [
            [
                'name' => 'Tiket Dewasa',
                'description' => 'Tiket masuk untuk pengunjung dewasa (di atas 12 tahun)',
                'price' => 15000,
                'quota' => 100,
                'is_active' => true,
            ],
            [
                'name' => 'Tiket Anak',
                'description' => 'Tiket masuk untuk pengunjung anak-anak (5-12 tahun)',
                'price' => 10000,
                'quota' => 100,
                'is_active' => true,
            ],
            [
                'name' => 'Tiket Gratis (Balita)',
                'description' => 'Tiket gratis untuk balita di bawah 5 tahun',
                'price' => 0,
                'quota' => 50,
                'is_active' => true,
            ],
        ];

        foreach ($tickets as $ticket) {
            Ticket::create($ticket);
        }
    }
}