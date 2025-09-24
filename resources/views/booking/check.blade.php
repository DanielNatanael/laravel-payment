@extends('layouts.app')

@section('title', 'Detail Booking - Pusat Latihan Gajah Minas')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto max-w-4xl">
        <!-- Booking Status Card -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Detail Booking</h1>
                <div class="text-2xl font-bold text-blue-600">{{ $booking->booking_code }}</div>
            </div>

            <!-- Status Badges -->
            <div class="flex justify-center space-x-4 mb-6">
                <span class="px-4 py-2 rounded-full text-sm font-medium
                    @if($booking->status == 'confirmed') bg-green-100 text-green-800
                    @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-800
                    @elseif($booking->status == 'cancelled') bg-red-100 text-red-800
                    @else bg-blue-100 text-blue-800 @endif">
                    Status: {{ ucfirst($booking->status) }}
                </span>
                <span class="px-4 py-2 rounded-full text-sm font-medium
                    @if($booking->payment_status == 'paid') bg-green-100 text-green-800
                    @elseif($booking->payment_status == 'pending') bg-yellow-100 text-yellow-800
                    @else bg-red-100 text-red-800 @endif">
                    Pembayaran: {{ ucfirst($booking->payment_status) }}
                </span>
            </div>

            <!-- Booking Details Grid -->
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-800 mb-3">Informasi Customer</h3>
                    <div class="space-y-2 text-sm">
                        <p><span class="font-medium">Nama:</span> {{ $booking->customer_name }}</p>
                        <p><span class="font-medium">Email:</span> {{ $booking->customer_email }}</p>
                        <p><span class="font-medium">Telepon:</span> {{ $booking->customer_phone }}</p>
                        @if($booking->notes)
                            <p><span class="font-medium">Catatan:</span> {{ $booking->notes }}</p>
                        @endif
                    </div>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-800 mb-3">Detail Kunjungan</h3>
                    <div class="space-y-2 text-sm">
                        <p><span class="font-medium">Tanggal:</span> {{ $booking->visit_date->format('d F Y') }}</p>
                        <p><span class="font-medium">Waktu:</span> {{ $booking->visit_time ? date('H:i', strtotime($booking->visit_time)) : '-' }}</p>
                        <p><span class="font-medium">Dibuat:</span> {{ $booking->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Ticket Details -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h3 class="font-semibold text-gray-800 mb-3">Detail Tiket</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-2">Jenis Tiket</th>
                                <th class="text-center py-2">Jumlah</th>
                                <th class="text-right py-2">Harga</th>
                                <th class="text-right py-2">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($booking->bookingItems as $item)
                            <tr class="border-b">
                                <td class="py-2">{{ $item->ticket->name }}</td>
                                <td class="text-center py-2">{{ $item->quantity }}</td>
                                <td class="text-right py-2">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="text-right py-2">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="border-t-2 font-bold">
                                <td colspan="3" class="py-3 text-right">Total:</td>
                                <td class="py-3 text-right text-lg">{{ $booking->formatted_total }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Action Buttons -->
<div class="flex flex-col sm:flex-row gap-4 justify-center">
    @if($booking->payment_status === 'pending')
        <a href="{{ route('payment.pay', $booking->booking_code) }}" 
           class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 text-center transition duration-200">
            💳 Bayar Sekarang
        </a>
    @endif
    
    <a href="{{ route('booking.index') }}" 
       class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 text-center transition duration-200">
        Booking Baru
    </a>
    <button onclick="window.print()" 
            class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition duration-200">
        Print Booking
    </button>
</div>
        </div>

        <!-- Instructions -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="font-semibold text-blue-800 mb-3">Petunjuk untuk Pengunjung</h3>
            <div class="grid md:grid-cols-2 gap-4 text-sm text-blue-700">
                <div>
                    <h4 class="font-semibold mb-2">Sebelum Datang:</h4>
                    <ul class="space-y-1">
                        <li>• Simpan kode booking dengan baik</li>
                        <li>• Datang 15 menit sebelum waktu kunjungan</li>
                        <li>• Siapkan pembayaran jika belum lunas</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-2">Saat Check-in:</h4>
                    <ul class="space-y-1">
                        <li>• Tunjukkan kode booking ke petugas</li>
                        <li>• Ikuti instruksi dari pemandu</li>
                        <li>• Nikmati pengalaman bersama gajah!</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection