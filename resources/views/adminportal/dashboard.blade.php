<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Admin</h2>
    </x-slot>

    @php
        $kamarKosong = $totalKamar - $kamarTerisi;
        $okupansi = $totalKamar > 0 ? round(($kamarTerisi / $totalKamar) * 100) : 0;

        $pintasan = [
            ['route' => 'adminportal.kamar', 'judul' => 'Kamar', 'desk' => 'Lihat status semua kamar', 'icon' => 'M4 6h16M4 12h16M4 18h7'],
            ['route' => 'adminportal.penghuni', 'judul' => 'Penghuni', 'desk' => 'Data penghuni dan kontaknya', 'icon' => 'M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-5.13a4 4 0 11-8 0 4 4 0 018 0zm6 3a4 4 0 10-8 0'],
            ['route' => 'adminportal.pembayaran', 'judul' => 'Pembayaran', 'desk' => 'Verifikasi pembayaran masuk', 'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
            ['route' => 'adminportal.komplain', 'judul' => 'Komplain', 'desk' => 'Tindak lanjuti keluhan penghuni', 'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
        ];
    @endphp

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Sambutan --}}
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl shadow-md p-7 text-white">
                <p class="text-sm text-slate-300">Selamat datang kembali,</p>
                <h3 class="text-2xl font-bold mt-1">{{ auth()->user()->name }} 👋</h3>
                <p class="text-sm text-slate-300 mt-5 mb-2">Properti yang kamu kelola</p>
                <div class="flex flex-wrap gap-2">
                    @forelse ($properti as $item)
                        <span class="px-3 py-1.5 rounded-full bg-white/10 text-sm font-medium">{{ $item->nama_properti }}</span>
                    @empty
                        <span class="text-sm text-slate-300">Belum ada properti yang ditugaskan</span>
                    @endforelse
                </div>
            </div>

            {{-- Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <p class="text-gray-500 text-sm font-medium">Total Kamar</p>
                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold mt-3 text-gray-800">{{ $totalKamar }}</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <p class="text-gray-500 text-sm font-medium">Kamar Terisi</p>
                        <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold mt-3 text-gray-800">{{ $kamarTerisi }}</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <p class="text-gray-500 text-sm font-medium">Kamar Kosong</p>
                        <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold mt-3 text-gray-800">{{ $kamarKosong }}</p>
                </div>
            </div>

            {{-- Okupansi --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <p class="font-semibold text-gray-800">Tingkat Okupansi</p>
                    <p class="text-2xl font-bold text-slate-700">{{ $okupansi }}%</p>
                </div>
                <div class="w-full h-3 rounded-full bg-gray-100 overflow-hidden">
                    <div class="h-full rounded-full bg-gradient-to-r from-slate-700 to-slate-900" style="width: {{ $okupansi }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">{{ $kamarTerisi }} dari {{ $totalKamar }} kamar sedang terisi</p>
            </div>

            {{-- Pintasan --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach ($pintasan as $p)
                    <a href="{{ route($p['route']) }}"
                        class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4 hover:shadow-md hover:-translate-y-0.5 transition">
                        <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-700 group-hover:bg-slate-800 group-hover:text-white flex items-center justify-center shrink-0 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $p['icon'] }}" /></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">{{ $p['judul'] }}</p>
                            <p class="text-sm text-gray-500">{{ $p['desk'] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>