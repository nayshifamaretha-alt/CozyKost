<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Kamar
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('kamar.update', $kamar->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Properti</label>
                        <select name="properti_id" class="mt-1 block w-full rounded-md border-gray-300">
                            @foreach ($properti as $item)
                                <option value="{{ $item->id }}" {{ old('properti_id', $kamar->properti_id) == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_properti }}
                                </option>
                            @endforeach
                        </select>
                        @error('properti_id')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Nomor Kamar</label>
                        <input type="text" name="nomor_kamar" value="{{ old('nomor_kamar', $kamar->nomor_kamar) }}" class="mt-1 block w-full rounded-md border-gray-300">
                        @error('nomor_kamar')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Harga Sewa (per bulan)</label>
                        <input type="number" name="harga_sewa" value="{{ old('harga_sewa', $kamar->harga_sewa) }}" class="mt-1 block w-full rounded-md border-gray-300">
                        @error('harga_sewa')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Fasilitas (opsional)</label>
                        <textarea name="fasilitas" class="mt-1 block w-full rounded-md border-gray-300">{{ old('fasilitas', $kamar->fasilitas) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Status</label>
                        <select name="status" class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="kosong" {{ $kamar->status == 'kosong' ? 'selected' : '' }}>Kosong</option>
                            <option value="terisi" {{ $kamar->status == 'terisi' ? 'selected' : '' }}>Terisi</option>
                        </select>
                    </div>

                    <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded">Update Kamar</button>
                    <a href="{{ route('kamar.index') }}" class="ml-2 text-gray-600">Batal</a>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>