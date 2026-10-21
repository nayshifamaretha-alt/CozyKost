<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Tagihan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6">

                <form action="{{ route('tagihan.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Penghuni</label>
                        <select name="penghuni_id" class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="">-- Pilih Penghuni --</option>
                            @foreach ($penghuni as $item)
                                <option value="{{ $item->id }}" {{ old('penghuni_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama }} - Kamar {{ $item->kamar->nomor_kamar }}
                                </option>
                            @endforeach
                        </select>
                        @error('penghuni_id')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Jumlah Tagihan</label>
                        <input type="number" name="jumlah" value="{{ old('jumlah') }}" class="mt-1 block w-full rounded-md border-gray-300">
                        @error('jumlah')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Jatuh Tempo</label>
                        <input type="date" name="jatuh_tempo" value="{{ old('jatuh_tempo') }}" class="mt-1 block w-full rounded-md border-gray-300">
                        @error('jatuh_tempo')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="bg-gradient-to-r from-purple-600 to-pink-500 text-white px-5 py-2.5 rounded-full font-medium shadow-sm hover:opacity-90">Simpan Tagihan</button>
                    <a href="{{ route('tagihan.index') }}" class="ml-2 text-gray-600">Batal</a>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>