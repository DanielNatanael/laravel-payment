<div class="max-w-4xl mx-auto p-6">
    <!-- Progress Indicator -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center {{ $step >= 1 ? 'text-blue-600' : 'text-gray-400' }}">
                <div class="flex items-center justify-center w-8 h-8 border-2 {{ $step >= 1 ? 'border-blue-600 bg-blue-600 text-white' : 'border-gray-300' }} rounded-full">1</div>
                <span class="ml-2">Pilih Tiket</span>
            </div>
            <div class="flex-1 h-px bg-gray-300 mx-4"></div>
            <div class="flex items-center {{ $step >= 2 ? 'text-blue-600' : 'text-gray-400' }}">
                <div class="flex items-center justify-center w-8 h-8 border-2 {{ $step >= 2 ? 'border-blue-600 bg-blue-600 text-white' : 'border-gray-300' }} rounded-full">2</div>
                <span class="ml-2">Data Diri</span>
            </div>
            <div class="flex-1 h-px bg-gray-300 mx-4"></div>
            <div class="flex items-center {{ $step >= 3 ? 'text-blue-600' : 'text-gray-400' }}">
                <div class="flex items-center justify-center w-8 h-8 border-2 {{ $step >= 3 ? 'border-blue-600 bg-blue-600 text-white' : 'border-gray-300' }} rounded-full">3</div>
                <span class="ml-2">Konfirmasi</span>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Step 1: Pilih Tiket -->
    @if($step == 1)
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-6">Pilih Tiket Masuk</h2>
            
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kunjungan</label>
                    <input type="date" wire:model="visit_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Waktu Kunjungan</label>
                    <select wire:model="visit_time" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="09:00">09:00</option>
                        <option value="10:00">10:00</option>
                        <option value="11:00">11:00</option>
                        <option value="13:00">13:00</option>
                        <option value="14:00">14:00</option>
                        <option value="15:00">15:00</option>
                    </select>
                </div>
            </div>

            <div class="space-y-4 mb-6">
                @foreach($tickets as $ticket)
                    <div class="border rounded-lg p-4 flex items-center justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-lg">{{ $ticket->name }}</h3>
                            <p class="text-gray-600 text-sm">{{ $ticket->description }}</p>
                            <p class="text-blue-600 font-bold">{{ $ticket->formatted_price }}</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <button wire:click="$set('selectedTickets.{{ $ticket->id }}', {{ max(0, ($selectedTickets[$ticket->id] ?? 0) - 1) }})" 
                                    class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300">
                                -
                            </button>
                            <span class="w-12 text-center font-semibold">{{ $selectedTickets[$ticket->id] ?? 0 }}</span>
                            <button wire:click="$set('selectedTickets.{{ $ticket->id }}', {{ ($selectedTickets[$ticket->id] ?? 0) + 1 }})" 
                                    class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center hover:bg-blue-600">
                                +
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-between items-center">
                <div class="text-xl font-bold">
                    Total: Rp {{ number_format($totalAmount, 0, ',', '.') }}
                </div>
                <button wire:click="nextStep" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Lanjutkan
                </button>
            </div>
        </div>
    @endif

    <!-- Step 2: Data Diri -->
    @if($step == 2)
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-6">Data Diri</h2>
            
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" wire:model="customer_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('customer_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" wire:model="customer_email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('customer_email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                    <input type="text" wire:model="customer_phone" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('customer_phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                    <textarea wire:model="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
            </div>

            <div class="flex justify-between items-center">
                <button wire:click="previousStep" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                    Kembali
                </button>
                <div class="text-xl font-bold">
                    Total: Rp {{ number_format($totalAmount, 0, ',', '.') }}
                </div>
                <button wire:click="nextStep" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Lanjutkan
                </button>
            </div>
        </div>
    @endif

    <!-- Step 3: Konfirmasi -->
    @if($step == 3)
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-6">Konfirmasi Booking</h2>
            
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="font-semibold mb-3">Detail Kunjungan</h3>
                    <p><strong>Tanggal:</strong> {{ date('d/m/Y', strtotime($visit_date)) }}</p>
                    <p><strong>Waktu:</strong> {{ $visit_time }}</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-3">Data Customer</h3>
                    <p><strong>Nama:</strong> {{ $customer_name }}</p>
                    <p><strong>Email:</strong> {{ $customer_email }}</p>
                    <p><strong>Telepon:</strong> {{ $customer_phone }}</p>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="font-semibold mb-3">Detail Tiket</h3>
                <div class="space-y-2">
                    @foreach($selectedTickets as $ticketId => $quantity)
                        @if($quantity > 0)
                            @php $ticket = $tickets->find($ticketId) @endphp
                            <div class="flex justify-between">
                                <span>{{ $ticket->name }} x {{ $quantity }}</span>
                                <span>Rp {{ number_format($ticket->price * $quantity, 0, ',', '.') }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>
                <hr class="my-3">
                <div class="flex justify-between font-bold text-lg">
                    <span>Total</span>
                    <span>Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="flex justify-between items-center">
                <button wire:click="previousStep" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                    Kembali
                </button>
                <button wire:click="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                    Konfirmasi Booking
                </button>
            </div>
        </div>
    @endif
</div>