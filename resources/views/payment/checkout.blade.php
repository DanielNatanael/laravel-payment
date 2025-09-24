@extends('layouts.app')

@section('title', 'Pembayaran - Pusat Latihan Gajah Minas')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto max-w-4xl">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Pembayaran</h1>
                <p class="text-gray-600">Kode Booking: <span class="font-semibold">{{ $booking->booking_code }}</span></p>
            </div>

            <!-- Booking Summary -->
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Ringkasan Booking</h2>
                
                <div class="grid md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <h3 class="font-medium text-gray-700 mb-2">Customer</h3>
                        <p class="text-sm">{{ $booking->customer_name }}</p>
                        <p class="text-sm">{{ $booking->customer_email }}</p>
                        <p class="text-sm">{{ $booking->customer_phone }}</p>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-700 mb-2">Kunjungan</h3>
                        <p class="text-sm">{{ $booking->visit_date->format('d F Y') }}</p>
                        <p class="text-sm">{{ $booking->visit_time ? date('H:i', strtotime($booking->visit_time)) : '-' }}</p>
                    </div>
                </div>

                <div class="border-t pt-4">
                    <h3 class="font-medium text-gray-700 mb-2">Detail Tiket</h3>
                    @foreach($booking->bookingItems as $item)
                        <div class="flex justify-between items-center py-1 text-sm">
                            <span>{{ $item->ticket->name }} x {{ $item->quantity }}</span>
                            <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                    <div class="flex justify-between items-center pt-3 border-t border-gray-300 text-lg font-bold">
                        <span>Total Pembayaran</span>
                        <span class="text-green-600">{{ $booking->formatted_total }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Button -->
            <div class="text-center">
                <button id="pay-button" class="bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-8 rounded-lg text-lg transition duration-200">
                    Bayar Sekarang
                </button>
                <p class="text-sm text-gray-500 mt-2">Anda akan diarahkan ke halaman pembayaran yang aman</p>
            </div>
        </div>
    </div>
</div>

<!-- Midtrans Snap JS -->
<script src="https://app{{ config('midtrans.is_production') ? '' : '.sandbox' }}.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>

<script type="text/javascript">
document.getElementById('pay-button').addEventListener('click', function () {
    // Disable button to prevent double click
    this.disabled = true;
    this.innerHTML = 'Memproses...';
    
    snap.pay('{{ $snapToken }}', {
        // Optional
        onSuccess: function(result) {
            console.log('Payment success:', result);
            window.location.href = "{{ route('payment.finish', $booking->booking_code) }}?status=success";
        },
        // Optional
        onPending: function(result) {
            console.log('Payment pending:', result);
            window.location.href = "{{ route('payment.finish', $booking->booking_code) }}?status=pending";
        },
        // Optional
        onError: function(result) {
            console.log('Payment error:', result);
            window.location.href = "{{ route('payment.finish', $booking->booking_code) }}?status=error";
        },
        onClose: function() {
            // Re-enable button if user closes the payment popup
            document.getElementById('pay-button').disabled = false;
            document.getElementById('pay-button').innerHTML = 'Bayar Sekarang';
        }
    });
});
</script>
@endsection