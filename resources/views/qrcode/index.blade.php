<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My QR Codes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('qrcode.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    + Create New QR Code
                </a>
            </div>

            @if ($qrCodes->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 text-center">
                        Belum ada QR Code. <a href="{{ route('qrcode.create') }}" class="text-blue-600 hover:underline">Buat sekarang!</a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($qrCodes as $qr)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex justify-center mb-4">
                                    @if ($qr->filename)
                                        <img src="{{ Storage::url($qr->filename) }}" alt="{{ $qr->title }}" class="max-w-full h-auto" style="max-height: 200px;">
                                    @endif
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $qr->title }}</h3>
                                <p class="text-sm text-gray-500 mt-1 truncate">{{ $qr->content }}</p>
                                <div class="mt-2 flex items-center gap-2 text-xs text-gray-400">
                                    <span class="px-2 py-1 bg-gray-100 rounded">{{ ucfirst($qr->type) }}</span>
                                    <span>{{ $qr->scan_count }} scans</span>
                                </div>
                                <div class="mt-4 flex gap-2">
                                    <a href="{{ route('qrcode.show', $qr) }}" class="text-sm text-blue-600 hover:underline">View</a>
                                    <a href="{{ route('qrcode.edit', $qr) }}" class="text-sm text-yellow-600 hover:underline">Edit</a>
                                    <form method="POST" action="{{ route('qrcode.destroy', $qr) }}" onsubmit="return confirm('Hapus QR Code ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 hover:underline">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $qrCodes->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
