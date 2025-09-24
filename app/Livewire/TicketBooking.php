<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\Booking;
use App\Models\BookingItem;
use Illuminate\Support\Facades\DB;

class TicketBooking extends Component
{
    public $customer_name = '';
    public $customer_email = '';
    public $customer_phone = '';
    public $visit_date = '';
    public $visit_time = '09:00';
    public $notes = '';
    
    public $tickets = [];
    public $selectedTickets = [];
    public $totalAmount = 0;
    public $step = 1; // 1: pilih tiket, 2: isi data, 3: konfirmasi

    protected $rules = [
        'customer_name' => 'required|string|max:255',
        'customer_email' => 'required|email|max:255',
        'customer_phone' => 'required|string|max:20',
        'visit_date' => 'required|date|after:today',
        'visit_time' => 'required',
    ];

    public function mount()
    {
        $this->tickets = Ticket::where('is_active', true)->get();
        $this->visit_date = now()->addDay()->format('Y-m-d');
        
        // Initialize selectedTickets array
        foreach ($this->tickets as $ticket) {
            $this->selectedTickets[$ticket->id] = 0;
        }
    }

    public function updatedSelectedTickets()
    {
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->totalAmount = 0;
        
        foreach ($this->selectedTickets as $ticketId => $quantity) {
            if ($quantity > 0) {
                $ticket = $this->tickets->find($ticketId);
                if ($ticket) {
                    $this->totalAmount += $ticket->price * $quantity;
                }
            }
        }
    }

    public function nextStep()
    {
        if ($this->step == 1) {
            // Validasi minimal 1 tiket dipilih
            $hasTickets = false;
            foreach ($this->selectedTickets as $quantity) {
                if ($quantity > 0) {
                    $hasTickets = true;
                    break;
                }
            }
            
            if (!$hasTickets) {
                session()->flash('error', 'Pilih minimal 1 tiket untuk melanjutkan.');
                return;
            }
        }

        if ($this->step == 2) {
            $this->validate();
        }

        $this->step++;
    }

    public function previousStep()
    {
        $this->step--;
    }

    public function submit()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            // Buat booking
            $booking = Booking::create([
                'customer_name' => $this->customer_name,
                'customer_email' => $this->customer_email,
                'customer_phone' => $this->customer_phone,
                'visit_date' => $this->visit_date,
                'visit_time' => $this->visit_time,
                'total_amount' => $this->totalAmount,
                'notes' => $this->notes,
            ]);

            // Buat booking items
            foreach ($this->selectedTickets as $ticketId => $quantity) {
                if ($quantity > 0) {
                    $ticket = $this->tickets->find($ticketId);
                    BookingItem::create([
                        'booking_id' => $booking->id,
                        'ticket_id' => $ticketId,
                        'quantity' => $quantity,
                        'price' => $ticket->price,
                        'subtotal' => $ticket->price * $quantity,
                    ]);
                }
            }

            DB::commit();

            session()->flash('success', 'Booking berhasil dibuat! Kode booking: ' . $booking->booking_code);
            
            // Redirect ke halaman sukses
            return redirect()->route('booking.success', $booking->booking_code);

        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'Terjadi kesalahan saat memproses booking. Silakan coba lagi.');
        }
    }

    public function render()
    {
        return view('livewire.ticket-booking');
    }
}