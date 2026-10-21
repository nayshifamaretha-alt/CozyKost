<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Update Status Komplain
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6">

                <p class="mb-2"><strong>Penghuni:</strong> {{ $komplain->penghuni->nama }}</p>
                <p class="mb-2"><strong>Kategori:</strong> {{ $komplain->kategori }}</p>
                <p class="mb-4"><strong>Deskripsi:</strong> {{ $komplain->deskripsi }}</p>

                <form action="{{ route('komplain.update', $komplain->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Status</label>
                        <select name="status" class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="diproses" {{ $komplain->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ $komplain->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    <button type="submit" class="bg-gradient-to-r from-purple-600 to-pink-500 text-white px-5 py-2.5 rounded-full font-medium shadow-sm hover:opacity-90">Update Status</button>
                    <a href="{{ route('komplain.index') }}" class="ml-2 text-gray-600">Batal</a>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>