<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Catat Pembayaran
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6">

                <form action="{{ route('pembayaran.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Tagihan</label>
                        <select name="tagihan_id" class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="">-- Pilih Tagihan --</option>
                            @foreach ($tagihan as $item)
                                <option value="{{ $item->id }}" {{ old('tagihan_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->penghuni->nama }} - Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('tagihan_id')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Jumlah Bayar</label>
                        <input type="number" name="jumlah_bayar" value="{{ old('jumlah_bayar') }}" class="mt-1 block w-full rounded-md border-gray-300">
                        @error('jumlah_bayar')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Tanggal Bayar</label>
                        <input type="date" name="tanggal_bayar" value="{{ old('tanggal_bayar') }}" class="mt-1 block w-full rounded-md border-gray-300">
                        @error('tanggal_bayar')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="bg-gradient-to-r from-purple-600 to-pink-500 text-white px-5 py-2.5 rounded-full font-medium shadow-sm hover:opacity-90">Simpan Pembayaran</button>
                    <a href="{{ route('pembayaran.index') }}" class="ml-2 text-gray-600">Batal</a>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>