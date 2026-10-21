<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Penghuni
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
                <p class="text-gray-500 text-sm">Total {{ $penghuni->count() }} penghuni</p>
                <a href="{{ route('penghuni.create') }}" class="bg-gradient-to-r from-slate-800 to-slate-900 text-white px-5 py-2.5 rounded-full font-medium shadow-sm hover:opacity-90">
                    + Tambah Penghuni
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse ($penghuni as $item)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition flex flex-col">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-full bg-gradient-to-br from-slate-700 to-slate-900 flex items-center justify-center text-white font-semibold shrink-0">
                                {{ strtoupper(substr($item->nama, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">{{ $item->nama }}</p>
                                <p class="text-xs text-gray-500">Kamar {{ $item->kamar->nomor_kamar }}</p>
                            </div>
                        </div>

                        <div class="mt-3 flex items-center justify-between">
                            <p class="text-sm text-gray-500">{{ $item->no_hp }}</p>
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $item->status == 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </div>

                        <div class="flex gap-2 mt-auto pt-4 border-t border-gray-100">
                            <a href="{{ route('penghuni.edit', $item->id) }}" class="flex-1 text-center text-sm text-slate-700 font-medium bg-slate-100 py-2 rounded-lg hover:bg-slate-200">Edit</a>
                            <form action="{{ route('penghuni.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus?')" class="flex-1">
                                <button type="submit" class="w-full text-sm text-red-600 font-medium bg-red-50 py-2 rounded-lg hover:bg-red-100">Hapus</button>
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center text-gray-500">
                        Belum ada penghuni. Yuk tambah dulu!
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>