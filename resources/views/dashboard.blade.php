<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-3xl font-bold text-gray-900">{{ $totalQrCodes }}</div>
                        <div class="text-sm text-gray-500 mt-1">Total QR Codes</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-3xl font-bold text-gray-900">{{ $totalScans }}</div>
                        <div class="text-sm text-gray-500 mt-1">Total Scans</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-3xl font-bold text-gray-900">{{ $recentQrCodes }}</div>
                        <div class="text-sm text-gray-500 mt-1">Created This Week</div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Quick Actions</h3>
                        <a href="{{ route('qrcode.create') }}" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Create QR Code
                        </a>
                    </div>
                    <p class="text-gray-500">Welcome to your QR Code generator! Create and manage QR codes for URLs, text, emails, and more.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
