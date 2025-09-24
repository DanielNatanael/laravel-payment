@extends('layouts.app')

@section('title', 'Status Pembayaran - Pusat Latihan Gajah Minas')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto max-w-3xl">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="text-center mb-8">
                @if(request('status') === 'success')
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-green-600 mb-2">Pembayaran Berhasil!</h1>
                    <p class="text-gray-600">Terima kasih, pembayaran Anda telah berhasil diproses</p>
                @elseif(request('status') === 'pending')
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-yellow-600 mb-2">Pembayaran Pending</h1>
                    <p class="text-gray-600">Pembayaran Anda sedang diproses, silakan tunggu konfirmasi</p>
                @else
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-red-600 mb-2">Pembayaran Gagal</h1>
                    <p class="text-gray-600">Terjadi kesalahan dalam proses pembayaran</p>
                @endif
            </div>

            <!-- Booking Info -->
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Detail Booking</h2>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm"><strong>Kode Booking:</strong> {{ $booking->booking_code }}</p>
                        <p class="text-sm"><strong>Customer:</strong> {{ $booking->customer_name }}</p>
                        <p class="text-sm"><strong>Email:</strong> {{ $booking->customer_email }}</p>
                    </div>
                    <div>
                        <p class="text-sm"><strong>Tanggal Kunjungan:</strong> {{ $booking->visit_date->format('d F Y') }}</p>
                        <p class="text-sm"><strong>Total:</strong> {{ $booking->formatted_total }}</p>
                        <p class="text-sm"><strong>Status:</strong> 
                            <span class="px-2 py-1 rounded text-xs
                                @if($booking->payment_status === 'paid') bg-green-100 text-green-800
                                @elseif($booking->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($booking->payment_status) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center space-y-4">
                @if(request('status') === 'success')
                    <a href="{{ route('booking.check', $booking->booking_code) }}" 
                       class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-200">
                        Lihat Detail Booking
                    </a>
                @elseif(request('status') === 'error')
                    <a href="{{ route('payment.pay', $booking->booking_code) }}" 
                       class="inline-block bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition duration-200">
                        Coba Bayar Lagi
                    </a>
                @endif
                
                <div>
                    <a href="{{ route('booking.index') }}" 
                       class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200">
                        Booking Baru
                    </a>
                    <a href="/" 
                       class="inline-block bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition duration-200">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection