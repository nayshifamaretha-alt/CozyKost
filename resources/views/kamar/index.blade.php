<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Kamar
        </h2>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded-xl mb-5 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Informasi dan tombol tambah -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
                <p class="text-gray-500 text-sm">
                    Total {{ $kamar->count() }} kamar
                </p>

                <a href="{{ route('kamar.create') }}"
                   class="inline-flex items-center justify-center bg-gradient-to-r from-slate-800 to-slate-900 text-white px-5 py-3 rounded-xl font-medium text-sm shadow-sm hover:opacity-90 w-full sm:w-auto">
                    + Tambah Kamar
                </a>
            </div>

            <!-- Daftar kamar -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">

                @forelse ($kamar as $item)

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition flex flex-col min-w-0">

                        <!-- Header kartu -->
                        <div class="flex justify-between items-start gap-3">
                            <div class="min-w-0">
                                <p class="font-semibold text-gray-800">
                                    Kamar {{ $item->nomor_kamar }}
                                </p>

                                <p class="text-xs text-gray-500 mt-1 break-words">
                                    {{ $item->properti->nama_properti }}
                                </p>
                            </div>

                            <span class="shrink-0 px-3 py-1 rounded-full text-xs font-medium {{ $item->status == 'terisi' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </div>

                        <!-- Harga -->
                        <p class="text-lg font-bold text-slate-700 mt-4">
                            Rp {{ number_format($item->harga_sewa, 0, ',', '.') }}
                            <span class="text-xs font-normal text-gray-400">/bulan</span>
                        </p>

                        <!-- Fasilitas -->
                        @if ($item->fasilitas)
                            <p class="text-xs text-gray-500 mt-2 break-words">
                                {{ $item->fasilitas }}
                            </p>
                        @endif

                        <!-- Tombol aksi -->
                        <div class="grid grid-cols-2 gap-3 mt-auto pt-5 border-t border-gray-100">

                            <a href="{{ route('kamar.edit', $item->id) }}"
                               class="flex items-center justify-center h-11 rounded-xl bg-slate-100 text-slate-700 text-sm font-semibold hover:bg-slate-200 transition">
                                Edit
                            </a>

                            <form action="{{ route('kamar.destroy', $item->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin mau hapus kamar ini?')"
                                  class="w-full">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="flex items-center justify-center w-full h-11 rounded-xl bg-red-50 text-red-600 text-sm font-semibold hover:bg-red-100 transition">
                                    Hapus
                                </button>
                            </form>

                        </div>

                    </div>

                @empty

                    <div class="col-span-full bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center text-gray-500">
                        Belum ada kamar. Yuk tambah dulu!
                    </div>

                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>
