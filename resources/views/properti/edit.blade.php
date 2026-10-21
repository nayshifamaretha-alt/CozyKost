<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Properti
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6">

                @if ($properti->foto)
                    <img src="{{ asset('storage/' . $properti->foto) }}" class="w-full h-48 object-cover rounded-xl mb-4">
                @endif

                <form action="{{ route('properti.update', $properti->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Nama Properti</label>
                        <input type="text" name="nama_properti" value="{{ old('nama_properti', $properti->nama_properti) }}" class="mt-1 block w-full rounded-md border-gray-300">
                        @error('nama_properti')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Alamat</label>
                        <textarea name="alamat" class="mt-1 block w-full rounded-md border-gray-300">{{ old('alamat', $properti->alamat) }}</textarea>
                        @error('alamat')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Deskripsi (opsional)</label>
                        <textarea name="deskripsi" class="mt-1 block w-full rounded-md border-gray-300">{{ old('deskripsi', $properti->deskripsi) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Ganti Foto (opsional)</label>
                        <input type="file" name="foto" accept="image/*" class="mt-1 block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-purple-50 file:text-purple-700 file:font-medium hover:file:bg-purple-100">
                        @error('foto')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="bg-gradient-to-r from-purple-600 to-pink-500 text-white px-5 py-2.5 rounded-full font-medium shadow-sm hover:opacity-90">Update Properti</button>
                    <a href="{{ route('properti.index') }}" class="ml-2 text-gray-600">Batal</a>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>