<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Admin
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
                <p class="text-gray-500 text-sm">Total {{ $properti->count() }} properti</p>
                <a href="{{ route('admin.create') }}" class="bg-gradient-to-r from-slate-800 to-slate-900 text-white px-5 py-2.5 rounded-full font-medium shadow-sm hover:opacity-90">
                    + Tambah Admin
                </a>
            </div>

            <div class="space-y-4">
                @forelse ($properti as $item)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2M5 21H3m4-14h6m-6 4h6m-6 4h6" /></svg>
                            <p class="font-semibold text-gray-800">{{ $item->nama_properti }}</p>
                        </div>

                        @forelse ($item->admin as $adm)
                            <div class="flex justify-between items-center bg-gray-50 rounded-xl px-4 py-3 mt-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-slate-700 to-slate-900 flex items-center justify-center text-white text-sm font-semibold shrink-0">
                                        {{ strtoupper(substr($adm->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">{{ $adm->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $adm->email }}</p>
                                    </div>
                                </div>
                                <form action="{{ route('admin.destroy', [$adm->id, $item->id]) }}" method="POST" onsubmit="return confirm('Yakin mau hapus admin ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600 font-medium bg-red-50 px-3 py-1.5 rounded-lg hover:bg-red-100">Hapus</button>
                                </form>
                            </div>
                        @empty
                            <p class="text-gray-400 text-sm mt-1 pl-1">Belum ada admin ditugaskan.</p>
                        @endforelse
                    </div>
                @empty
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center text-gray-500">
                        Belum ada properti.
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>