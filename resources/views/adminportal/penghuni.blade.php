@php
    $listProperti = $penghuni->map(fn ($i) => $i->kamar?->properti?->nama_properti)->filter()->unique()->sort()->values();
    $listStatus = $penghuni->pluck('status')->filter()->unique()->values();
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Penghuni</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row gap-3 mb-5">
                <div class="relative flex-1">
                    <svg class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" /></svg>
                    <input id="cari" type="text" oninput="terapkanFilter()" placeholder="Cari nama, nomor HP, atau nomor kamar..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-2xl border-gray-200 bg-white shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-100">
                </div>
                <select id="filter1" onchange="terapkanFilter()" class="rounded-2xl border-gray-200 bg-white shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-100">
                    <option value="">Semua Properti</option>
                    @foreach ($listProperti as $p)
                        <option value="{{ $p }}">{{ $p }}</option>
                    @endforeach
                </select>
                <select id="filter2" onchange="terapkanFilter()" class="rounded-2xl border-gray-200 bg-white shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-100">
                    <option value="">Semua Status</option>
                    @foreach ($listStatus as $s)
                        <option value="{{ $s }}">{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button type="button" onclick="resetFilter()" class="px-4 py-2.5 rounded-2xl bg-white border border-gray-200 shadow-sm text-sm font-medium text-slate-700 hover:bg-slate-100">Reset</button>
            </div>

            <p class="text-gray-500 text-sm mb-6">
                Menampilkan <span id="jumlah" class="font-semibold text-gray-700">{{ $penghuni->count() }}</span> dari {{ $penghuni->count() }} penghuni
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse ($penghuni as $item)
                    <div data-item
                         data-cari="{{ strtolower($item->nama . ' ' . $item->no_hp . ' ' . ($item->kamar?->nomor_kamar ?? '')) }}"
                         data-f1="{{ $item->kamar?->properti?->nama_properti }}"
                         data-f2="{{ $item->status }}"
                         class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-full bg-gradient-to-br from-slate-700 to-slate-900 flex items-center justify-center text-white font-semibold shrink-0">
                                {{ strtoupper(substr($item->nama, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="font-semibold text-gray-800 truncate">{{ $item->nama }}</p>
                                <p class="text-xs text-gray-500 truncate">
                                    Kamar {{ $item->kamar?->nomor_kamar ?? '-' }}
                                    @if ($item->kamar?->properti) · {{ $item->kamar->properti->nama_properti }} @endif
                                </p>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center justify-between">
                            <p class="text-sm text-gray-500">{{ $item->no_hp }}</p>
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $item->status == 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center text-gray-500">Belum ada penghuni.</div>
                @endforelse

                <div id="kosong" class="hidden col-span-full bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center text-gray-500">
                    Tidak ada penghuni yang cocok dengan pencarianmu.
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        function terapkanFilter() {
            const kata = document.getElementById('cari').value.trim().toLowerCase();
            const f1 = document.getElementById('filter1').value;
            const f2 = document.getElementById('filter2').value;
            const items = document.querySelectorAll('[data-item]');
            let tampil = 0;

            items.forEach(function (el) {
                const cocok = (!kata || el.dataset.cari.includes(kata))
                    && (!f1 || el.dataset.f1 === f1)
                    && (!f2 || el.dataset.f2 === f2);
                el.classList.toggle('hidden', !cocok);
                if (cocok) tampil++;
            });

            document.getElementById('jumlah').textContent = tampil;
            document.getElementById('kosong').classList.toggle('hidden', tampil !== 0 || items.length === 0);
        }

        function resetFilter() {
            document.getElementById('cari').value = '';
            document.getElementById('filter1').value = '';
            document.getElementById('filter2').value = '';
            terapkanFilter();
        }
    </script>
    @endpush
</x-app-layout>