<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Komplain
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6">

                <form action="{{ route('komplain.store') }}" method="POST">
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
                        <label class="block font-medium text-sm text-gray-700">Kategori</label>
                        <input type="text" name="kategori" placeholder="Contoh: Kerusakan, Air, Listrik" value="{{ old('kategori') }}" class="mt-1 block w-full rounded-md border-gray-300">
                        @error('kategori')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" class="mt-1 block w-full rounded-md border-gray-300">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Prioritas</label>
                        <select name="prioritas" class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="rendah">Rendah</option>
                            <option value="sedang" selected>Sedang</option>
                            <option value="tinggi">Tinggi</option>
                        </select>
                    </div>

                    <button type="submit" class="bg-gradient-to-r from-purple-600 to-pink-500 text-white px-5 py-2.5 rounded-full font-medium shadow-sm hover:opacity-90">Simpan Komplain</button>
                    <a href="{{ route('komplain.index') }}" class="ml-2 text-gray-600">Batal</a>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>