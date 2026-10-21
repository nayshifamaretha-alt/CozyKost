<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Komplain
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded-xl mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-6">
                <p class="text-gray-500 text-sm">Total {{ $komplain->count() }} komplain</p>
                <a href="{{ route('komplain.create') }}" class="bg-gradient-to-r from-slate-800 to-slate-900 text-white px-5 py-2.5 rounded-full font-medium shadow-sm hover:opacity-90">
                    + Tambah Komplain
                </a>
            </div>

            <div class="space-y-3">
                @forelse ($komplain as $item)
                    @php
                        $prioColor = match($item->prioritas) {
                            'tinggi' => 'bg-red-100 text-red-600',
                            'sedang' => 'bg-yellow-100 text-yellow-700',
                            default => 'bg-gray-100 text-gray-700',
                        };
                    @endphp
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
                        <div class="flex justify-between items-start gap-4">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-slate-700 to-slate-900 flex items-center justify-center text-white font-semibold shrink-0">
                                    {{ strtoupper(substr($item->penghuni->nama, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $item->penghuni->nama }}</p>
                                    <p class="text-xs text-gray-500">{{ $item->kategori }}</p>
                                </div>
                            </div>
                            <div class="flex gap-2 shrink-0">
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $prioColor }}">{{ ucfirst($item->prioritas) }}</span>
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $item->status == 'selesai' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">{{ ucfirst($item->status) }}</span>
                            </div>
                        </div>

                        <p class="text-sm text-gray-600 mt-3 pl-13">{{ $item->deskripsi }}</p>

                        <div class="flex gap-2 mt-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('komplain.edit', $item->id) }}" class="flex-1 text-center text-sm text-slate-700 font-medium bg-slate-100 py-2 rounded-lg hover:bg-slate-200">Update Status</a>
                            <form action="{{ route('komplain.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus?')" class="flex-1">
                                <button type="submit" class="w-full text-sm text-red-600 font-medium bg-red-50 py-2 rounded-lg hover:bg-red-100">Hapus</button>
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center text-gray-500">
                        Belum ada komplain.
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>