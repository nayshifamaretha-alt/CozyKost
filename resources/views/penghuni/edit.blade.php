<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Penghuni
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6">

                <form action="{{ route('penghuni.update', $penghuni->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Kamar</label>
                        <select name="kamar_id" class="mt-1 block w-full rounded-md border-gray-300">
                            @foreach ($kamar as $item)
                                <option value="{{ $item->id }}" {{ old('kamar_id', $penghuni->kamar_id) == $item->id ? 'selected' : '' }}>
                                    {{ $item->properti->nama_properti }} - {{ $item->nomor_kamar }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Nama</label>
                        <input type="text" name="nama" value="{{ old('nama', $penghuni->nama) }}" class="mt-1 block w-full rounded-md border-gray-300">
                        @error('nama')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', $penghuni->email) }}" class="mt-1 block w-full rounded-md border-gray-300">
                        @error('email')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">No HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $penghuni->no_hp) }}" class="mt-1 block w-full rounded-md border-gray-300">
                        @error('no_hp')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', \Carbon\Carbon::parse($penghuni->tanggal_masuk)->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300">
                        @error('tanggal_masuk')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Status</label>
                        <select name="status" class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="aktif" {{ $penghuni->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ $penghuni->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <button type="submit" class="bg-gradient-to-r from-purple-600 to-pink-500 text-white px-5 py-2.5 rounded-full font-medium shadow-sm hover:opacity-90">Update Penghuni</button>
                    <a href="{{ route('penghuni.index') }}" class="ml-2 text-gray-600">Batal</a>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>