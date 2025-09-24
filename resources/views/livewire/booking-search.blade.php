<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Cek Status Booking</h2>
        
        <div class="mb-4">
            <div class="flex">
                <input type="text" 
                       wire:model="booking_code" 
                       wire:keydown.enter="search"
                       placeholder="Masukkan kode booking (contoh: PLG-123ABC)"
                       class="flex-1 px-4 py-3 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button wire:click="search" 
                        class="bg-blue-600 text-white px-6 py-3 rounded-r-lg hover:bg-blue-700 transition duration-200">
                    Cari
                </button>
            </div>
            
            @if($error)
                <p class="text-red-500 text-sm mt-2">{{ $error }}</p>
            @endif
        </div>

        @if($booking)
            <div class="mt-6 p-4 border border-gray-200 rounded-lg bg-gray-50">
                <div class="text-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">{{ $booking->booking_code }}</h3>
                    <div class="flex justify-center space-x-4 mt-2">
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            @if($booking->status == 'confirmed') bg-green-100 text-green-800
                            @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($booking->status == 'cancelled') bg-red-100 text-red-800
                            @else bg-blue-100 text-blue-800 @endif">
                            {{ ucfirst($booking->status) }}
                        </span>
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            @if($booking->payment_status == 'paid') bg-green-100 text-green-800
                            @elseif($booking->payment_status == 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            Payment: {{ ucfirst($booking->payment_status) }}
                        </span>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <h4 class="font-semibold text-gray-700 mb-2">Customer Info</h4>
                        <p class="text-sm"><strong>Nama:</strong> {{ $booking->customer_name }}</p>
                        <p class="text-sm"><strong>Email:</strong> {{ $booking->customer_email }}</p>
                        <p class="text-sm"><strong>Telepon:</strong> {{ $booking->customer_phone }}</p>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-700 mb-2">Visit Info</h4>
                        <p class="text-sm"><strong>Tanggal:</strong> {{ $booking->visit_date->format('d/m/Y') }}</p>
                        <p class="text-sm"><strong>Waktu:</strong> {{ $booking->visit_time ? date('H:i', strtotime($booking->visit_time)) : '-' }}</p>
                        <p class="text-sm"><strong>Total:</strong> {{ $booking->formatted_total }}</p>
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold text-gray-700 mb-2">Tiket</h4>
                    @foreach($booking->bookingItems as $item)
                        <div class="flex justify-between text-sm py-1">
                            <span>{{ $item->ticket->name }} x {{ $item->quantity }}</span>
                            <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 pt-4 border-t">
                    <a href="{{ route('booking.check', $booking->booking_code) }}" 
                       class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200">
                        Lihat Detail Lengkap
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>