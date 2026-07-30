<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create QR Code') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('qrcode.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                            <select name="type" id="type" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="text" {{ old('type') === 'text' ? 'selected' : '' }}>Text</option>
                                <option value="url" {{ old('type') === 'url' ? 'selected' : '' }}>URL</option>
                                <option value="email" {{ old('type') === 'email' ? 'selected' : '' }}>Email</option>
                                <option value="phone" {{ old('type') === 'phone' ? 'selected' : '' }}>Phone</option>
                                <option value="sms" {{ old('type') === 'sms' ? 'selected' : '' }}>SMS</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                            <textarea name="content" id="content" rows="4" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('content') }}</textarea>
                            <p id="content-hint" class="text-xs text-gray-500 mt-1">Enter the data to encode in the QR code</p>
                            @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="foreground_color" class="block text-sm font-medium text-gray-700">Foreground Color</label>
                                <input type="color" name="foreground_color" id="foreground_color" value="{{ old('foreground_color', '#000000') }}"
                                    class="mt-1 block w-full h-10 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="background_color" class="block text-sm font-medium text-gray-700">Background Color</label>
                                <input type="color" name="background_color" id="background_color" value="{{ old('background_color', '#ffffff') }}"
                                    class="mt-1 block w-full h-10 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="size" class="block text-sm font-medium text-gray-700">Size (px)</label>
                                <input type="number" name="size" id="size" value="{{ old('size', 300) }}" min="100" max="1000" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="format" class="block text-sm font-medium text-gray-700">Format</label>
                                <select name="format" id="format" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="png" {{ old('format') === 'png' ? 'selected' : '' }}>PNG</option>
                                    <option value="svg" {{ old('format') === 'svg' ? 'selected' : '' }}>SVG</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Generate QR Code
                            </button>
                            <a href="{{ route('qrcode.index') }}" class="text-sm text-gray-600 hover:underline">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('type').addEventListener('change', function() {
            const hint = document.getElementById('content-hint');
            const content = document.getElementById('content');
            switch(this.value) {
                case 'url': hint.textContent = 'Enter a full URL (e.g. https://example.com)'; break;
                case 'email': hint.textContent = 'Enter an email address'; break;
                case 'phone': hint.textContent = 'Enter a phone number (e.g. +628123456789)'; break;
                case 'sms': hint.textContent = 'Enter SMS number (e.g. +628123456789)'; break;
                default: hint.textContent = 'Enter the data to encode in the QR code';
            }
        });
    </script>
    @endpush
</x-app-layout>
