@extends('layouts.app')

@section('title', 'Booking Berhasil - Pusat Latihan Gajah Minas')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto max-w-3xl">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <!-- Success Icon -->
            <div class="text-center mb-6">
                <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-green-600 mb-2">Booking Berhasil!</h1>
                <p class="text-gray-600">Terima kasih telah melakukan booking tiket masuk</p>
            </div>

            <!-- Booking Details -->
            <div class="border-2 border-green-200 rounded-lg p-6 mb-6 bg-green-50">
                <div class="text-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Kode Booking</h2>
                    <div class="text-3xl font-bold text-green-600 bg-white px-4 py-2 rounded-lg inline-block mt-2">
                        {{ $booking->booking_code }}
                    </div>
                </div>
                <p class="text-sm text-gray-600 text-center">
                    Simpan kode booking ini untuk keperluan check-in dan konfirmasi pembayaran
                </p>
            </div>

            <!-- Customer Information -->
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-800 mb-3">Informasi Customer</h3>
                    <div class="space-y-2 text-sm">
                        <p><span class="font-medium">Nama:</span> {{ $booking->customer_name }}</p>
                        <p><span class="font-medium">Email:</span> {{ $booking->customer_email }}</p>
                        <p><span class="font-medium">Telepon:</span> {{ $booking->customer_phone }}</p>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-800 mb-3">Detail Kunjungan</h3>
                    <div class="space-y-2 text-sm">
                        <p><span class="font-medium">Tanggal:</span> {{ $booking->visit_date->format('d F Y') }}</p>
                        <p><span class="font-medium">Waktu:</span> {{ $booking->visit_time ? date('H:i', strtotime($booking->visit_time)) : '-' }}</p>
                        <p><span class="font-medium">Status:</span> 
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Ticket Details -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h3 class="font-semibold text-gray-800 mb-3">Detail Tiket</h3>
                <div class="space-y-2">
                    @foreach($booking->bookingItems as $item)
                        <div class="flex justify-between items-center py-2 border-b border-gray-200 last:border-b-0">
                            <div>
                                <span class="font-medium">{{ $item->ticket->name }}</span>
                                <span class="text-gray-600">x {{ $item->quantity }}</span>
                            </div>
                            <span class="font-medium">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-between items-center pt-3 border-t border-gray-300">
                    <span class="text-lg font-bold">Total</span>
                    <span class="text-lg font-bold text-green-600">{{ $booking->formatted_total }}</span>
                </div>
            </div>

            <!-- Payment Status -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-yellow-800">Menunggu Pembayaran</h4>
                        <p class="text-sm text-yellow-700">
                            Silakan lakukan pembayaran dan tunjukkan kode booking saat check-in di lokasi.
                        </p>
                    </div>
                </div>
            </div>

   <!-- Action Buttons -->
<div class="flex flex-col sm:flex-row gap-4 justify-center">
    @if($booking->payment_status === 'pending')
        <a href="{{ route('payment.pay', $booking->booking_code) }}" 
           class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 text-center transition duration-200"
           onclick="console.log('Payment button clicked!'); console.log('URL: {{ route('payment.pay', $booking->booking_code) }}');">
            💳 Bayar Sekarang
        </a>
    @else
        <div class="bg-red-100 p-3 rounded">
            <p>Tombol bayar tidak muncul karena payment_status = <strong>{{ $booking->payment_status }}</strong></p>
            <p>Seharusnya 'pending' untuk menampilkan tombol</p>
        </div>
    @endif
    
    <a href="{{ route('booking.index') }}" 
       class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 text-center transition duration-200">
        Booking Lagi
    </a>
    <a href="/" 
       class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 text-center transition duration-200">
        Kembali ke Beranda
    </a>
    <button onclick="window.print()" 
            class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition duration-200">
        Print Booking
    </button>
</div>
        </div>

            <!-- Instructions -->
            <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <h4 class="font-semibold text-blue-800 mb-2">Petunjuk Check-in:</h4>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li>• Datang 15 menit sebelum waktu kunjungan</li>
                    <li>• Tunjukkan kode booking kepada petugas</li>
                    <li>• Lakukan pembayaran di lokasi jika belum dibayar</li>
                    <li>• Ikuti instruksi dari pemandu wisata</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection