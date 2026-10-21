<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Properti
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded-xl mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-6">
                <p class="text-gray-500 text-sm">Total {{ $properti->count() }} properti</p>
                <a href="{{ route('properti.create') }}" class="bg-gradient-to-r from-slate-800 to-slate-900 text-white px-5 py-2.5 rounded-full font-medium shadow-sm hover:opacity-90">
                    + Tambah Properti
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse ($properti as $item)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                        <div class="h-36 bg-gradient-to-br from-slate-700 to-slate-800 flex items-center justify-center overflow-hidden">
                            @if ($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-12 h-12 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                            @endif
                        </div>
                        <div class="p-5">
                            <p class="font-semibold text-gray-800">{{ $item->nama_properti }}</p>
                            <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $item->alamat }}</p>
                            <p class="text-sm text-slate-700 font-medium mt-2">{{ $item->kamar->count() }} kamar</p>

                            <div class="flex gap-2 mt-4 pt-4 border-t border-gray-100">
                                <a href="{{ route('properti.edit', $item->id) }}" class="flex-1 text-center text-sm text-slate-700 font-medium bg-slate-100 py-2 rounded-lg hover:bg-slate-200">Edit</a>
                                <form action="{{ route('properti.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus?')" class="flex-1">
                                    <button type="submit" class="w-full text-sm text-red-600 font-medium bg-red-50 py-2 rounded-lg hover:bg-red-100">Hapus</button>
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center text-gray-500">
                        Belum ada properti. Yuk tambah dulu!
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>