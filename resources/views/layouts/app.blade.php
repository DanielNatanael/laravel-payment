<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pusat Latihan Gajah Minas')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    <style>
        @media print {
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-gray-50">
    <nav class="bg-green-600 shadow-lg no-print">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-white text-xl font-bold">
                        🐘 Pusat Latihan Gajah Minas
                    </a>
                </div>
                <div class="flex items-center space-x-4">
    <a href="/" class="text-white hover:text-green-200">Beranda</a>
    <a href="{{ route('booking.index') }}" class="text-white hover:text-green-200">Booking Tiket</a>
    <div class="relative">
        <button onclick="toggleSearchModal()" class="text-white hover:text-green-200">
            Cek Booking
        </button>
    </div>
</div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white py-8 mt-12 no-print">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; 2024 Pusat Latihan Gajah Minas. All rights reserved.</p>
        </div>
    </footer>

    @livewireScripts

    <!-- Search Modal -->
<div id="searchModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 no-print">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-md w-full">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Cek Status Booking</h3>
                    <button onclick="toggleSearchModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                @livewire('booking-search')
            </div>
        </div>
    </div>
</div>

<script>
function toggleSearchModal() {
    const modal = document.getElementById('searchModal');
    modal.classList.toggle('hidden');
}

// Close modal when clicking outside
document.getElementById('searchModal').addEventListener('click', function(e) {
    if (e.target === this) {
        toggleSearchModal();
    }
});
</script>
</body>
</html>