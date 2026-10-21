@php
    $namaBulan = ['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                  '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];
    $rank = ['menunggu' => 0, 'ditolak' => 1, 'diterima' => 2];

    $daftar = $pembayaran->map(function ($i) {
        $i->status_norm = in_array($i->status_verifikasi, ['diterima', 'terverifikasi']) ? 'diterima'
            : ($i->status_verifikasi == 'ditolak' ? 'ditolak' : 'menunggu');
        return $i;
    })->sort(function ($a, $b) use ($rank) {
        $ta = \Carbon\Carbon::parse($a->tanggal_bayar)->timestamp;
        $tb = \Carbon\Carbon::parse($b->tanggal_bayar)->timestamp;
        return [$rank[$a->status_norm], -$ta] <=> [$rank[$b->status_norm], -$tb];
    })->values();

    $jmlMenunggu = $daftar->where('status_norm', 'menunggu')->count();
    $jmlDiterima = $daftar->where('status_norm', 'diterima')->count();
    $totalDiterima = $daftar->where('status_norm', 'diterima')->sum('jumlah_bayar');

    $bulanList = $daftar->map(fn ($i) => \Carbon\Carbon::parse($i->tanggal_bayar)->format('Y-m'))->unique()->sortDesc()->values();
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Verifikasi Pembayaran</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded-xl mb-4">{{ session('success') }}</div>
            @endif

            {{-- Ringkasan --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="rounded-2xl p-5 bg-amber-50 border border-amber-100">
                    <p class="text-sm text-amber-700 font-medium">Menunggu Verifikasi</p>
                    <p class="text-3xl font-bold text-amber-800 mt-1">{{ $jmlMenunggu }}</p>
                </div>
                <div class="rounded-2xl p-5 bg-white border border-gray-100 shadow-sm">
                    <p class="text-sm text-gray-500 font-medium">Sudah Diterima</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $jmlDiterima }}</p>
                </div>
                <div class="rounded-2xl p-5 bg-gradient-to-br from-slate-800 to-slate-900 text-white shadow-md">
                    <p class="text-sm text-slate-300 font-medium">Total Pembayaran Diterima</p>
                    <p class="text-2xl font-bold mt-1">Rp {{ number_format($totalDiterima, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Pencarian dan filter --}}
            <div class="flex flex-col md:flex-row gap-3 mb-5">
                <div class="relative flex-1">
                    <svg class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" /></svg>
                    <input id="cari" type="text" oninput="terapkanFilter()" placeholder="Cari nama penghuni atau nomor kamar..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-2xl border-gray-200 bg-white shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-100">
                </div>
                <select id="filter1" onchange="terapkanFilter()" class="rounded-2xl border-gray-200 bg-white shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-100">
                    <option value="">Semua Status</option>
                    <option value="menunggu">Menunggu</option>
                    <option value="diterima">Diterima</option>
                    <option value="ditolak">Ditolak</option>
                </select>
                <select id="filter2" onchange="terapkanFilter()" class="rounded-2xl border-gray-200 bg-white shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-100">
                    <option value="">Semua Bulan</option>
                    @foreach ($bulanList as $b)
                        <option value="{{ $b }}">{{ $namaBulan[substr($b, 5, 2)] }} {{ substr($b, 0, 4) }}</option>
                    @endforeach
                </select>
                <button type="button" onclick="resetFilter()" class="px-4 py-2.5 rounded-2xl bg-white border border-gray-200 shadow-sm text-sm font-medium text-slate-700 hover:bg-slate-100">Reset</button>
            </div>

            <p class="text-gray-500 text-sm mb-4">
                Menampilkan <span id="jumlah" class="font-semibold text-gray-700">{{ $daftar->count() }}</span> dari {{ $daftar->count() }} pembayaran
            </p>

            <div class="space-y-3">
                @forelse ($daftar as $item)
                    @php
                        $penghuniItem = $item->tagihan?->penghuni;
                        $kamarItem = $penghuniItem?->kamar;
                        $nama = $penghuniItem?->nama ?? '-';
                        $badge = match($item->status_norm) {
                            'diterima' => 'bg-emerald-100 text-emerald-700',
                            'ditolak' => 'bg-red-100 text-red-600',
                            default => 'bg-yellow-100 text-yellow-700',
                        };
                    @endphp
                    <div data-item
                         data-cari="{{ strtolower($nama . ' ' . ($kamarItem?->nomor_kamar ?? '')) }}"
                         data-f1="{{ $item->status_norm }}"
                         data-f2="{{ \Carbon\Carbon::parse($item->tanggal_bayar)->format('Y-m') }}"
                         class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">

                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-11 h-11 rounded-full bg-gradient-to-br from-slate-700 to-slate-900 flex items-center justify-center text-white font-semibold shrink-0">
                                    {{ strtoupper(substr($nama, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-800 truncate">{{ $nama }}</p>
                                    <p class="text-xs text-gray-500 truncate">
                                        Kamar {{ $kamarItem?->nomor_kamar ?? '-' }}
                                        @if ($kamarItem?->properti) · {{ $kamarItem->properti->nama_properti }} @endif
                                    </p>
                                </div>
                            </div>

                            <div class="md:text-right">
                                <p class="font-bold text-slate-700">Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->tanggal_bayar)->format('d M Y') }}</p>
                            </div>

                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $badge }}">{{ ucfirst($item->status_norm) }}</span>

                                @if ($item->bukti_transfer)
                                    <a href="{{ asset('storage/' . $item->bukti_transfer) }}" target="_blank"
                                        class="text-xs text-slate-600 font-medium underline hover:text-slate-900">Lihat bukti</a>
                                @else
                                    <span class="text-xs text-gray-400">Tanpa bukti</span>
                                @endif

                                @if ($item->status_norm != 'diterima')
                                    <form action="{{ route('adminportal.pembayaran.verifikasi', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-sm text-white font-medium bg-gradient-to-r from-slate-800 to-slate-900 px-4 py-2 rounded-lg hover:opacity-90">Verifikasi</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center text-gray-500">Belum ada pembayaran.</div>
                @endforelse

                <div id="kosong" class="hidden bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center text-gray-500">
                    Tidak ada pembayaran yang cocok dengan pencarianmu.
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