<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Properti
        </h2>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded-xl mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
                <p class="text-gray-500 text-sm">
                    Total {{ $properti->count() }} properti
                </p>

                <a href="{{ route('properti.create') }}"
                   class="w-full sm:w-auto text-center bg-gradient-to-r from-slate-800 to-slate-900 text-white px-5 py-3 rounded-xl font-medium shadow-sm hover:opacity-90">
                    + Tambah Properti
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

                @forelse ($properti as $item)
                    <div class="min-w-0 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                        <div class="h-44 sm:h-40 bg-gradient-to-br from-slate-700 to-slate-800 flex items-center justify-center overflow-hidden">

                            @if ($item->foto)
                                <img
                                    src="{{ asset('storage/' . ltrim($item->foto, '/')) }}"
                                    alt="Foto {{ $item->nama_properti }}"
                                    class="w-full h-full object-cover"
                                    loading="lazy"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                >

                                <div class="hidden w-full h-full items-center justify-center text-white/70">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6" />
                                    </svg>
                                </div>
                            @else
                                <svg class="w-12 h-12 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6" />
                                </svg>
                            @endif

                        </div>

                        <div class="p-4 sm:p-5">
                            <p class="font-semibold text-gray-800 break-words">
                                {{ $item->nama_properti }}
                            </p>

                            <p class="text-sm text-gray-500 mt-1 break-words">
                                {{ $item->alamat }}
                            </p>

                            <p class="text-sm text-slate-700 font-medium mt-2">
                                {{ $item->kamar->count() }} kamar
                            </p>

                            <div class="flex flex-col sm:flex-row gap-2 mt-4 pt-4 border-t border-gray-100">
                                <a href="{{ route('properti.edit', $item->id) }}"
                                   class="flex-1 text-center text-sm text-slate-700 font-medium bg-slate-100 py-2.5 rounded-lg hover:bg-slate-200">
                                    Edit
                                </a>

                                <form action="{{ route('properti.destroy', $item->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin mau hapus?')"
                                      class="flex-1">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="w-full text-sm text-red-600 font-medium bg-red-50 py-2.5 rounded-lg hover:bg-red-100">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center text-gray-500">
                        Belum ada properti. Yuk tambah dulu!
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>
