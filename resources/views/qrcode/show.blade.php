<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $qrcode->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-center mb-6">
                        @if ($qrcode->filename)
                            <img src="{{ Storage::url($qrcode->filename) }}" alt="{{ $qrcode->title }}" class="max-w-full h-auto">
                        @endif
                    </div>

                    <div class="border-t pt-4">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Title</dt>
                                <dd class="text-sm text-gray-900">{{ $qrcode->title }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Type</dt>
                                <dd class="text-sm text-gray-900">{{ ucfirst($qrcode->type) }}</dd>
                            </div>
                            <div class="md:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Content</dt>
                                <dd class="text-sm text-gray-900 break-all">{{ $qrcode->content }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Size</dt>
                                <dd class="text-sm text-gray-900">{{ $qrcode->size }}px</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Format</dt>
                                <dd class="text-sm text-gray-900 uppercase">{{ $qrcode->format }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Scans</dt>
                                <dd class="text-sm text-gray-900">{{ $qrcode->scan_count }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Created</dt>
                                <dd class="text-sm text-gray-900">{{ $qrcode->created_at->format('d M Y, H:i') }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('qrcode.download', $qrcode) }}" class="px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500">
                            Download
                        </a>
                        <a href="{{ route('qrcode.edit', $qrcode) }}" class="px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-400">
                            Edit
                        </a>
                        <a href="{{ route('qrcode.index') }}" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Back to List
                        </a>
                        <form method="POST" action="{{ route('qrcode.destroy', $qrcode) }}" onsubmit="return confirm('Hapus QR Code ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
