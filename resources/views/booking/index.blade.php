@extends('layouts.app')

@section('title', 'Booking Tiket - Pusat Latihan Gajah Minas')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Booking Tiket Masuk</h1>
            <p class="text-gray-600">Pusat Latihan Gajah Minas - Pengalaman Tak Terlupakan bersama Gajah Sumatera</p>
        </div>

        @livewire('ticket-booking')
    </div>
</div>
@endsection