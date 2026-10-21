@php
    $namaBulan = ['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                  '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];

    $bulanTagihan = $tagihan
        ->map(fn ($i) => \Carbon\Carbon::parse($i->jatuh_tempo)->format('Y-m'))
        ->unique()->sortDesc()->values();

    $bulanPembayaran = $pembayaran
        ->map(fn ($i) => \Carbon\Carbon::parse($i->tanggal_bayar)->format('Y-m'))
        ->unique()->sortDesc()->values();
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Keuangan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded-xl mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex gap-2 mb-6 border-b">
                <button onclick="switchTab('tagihan')" id="tab-tagihan" class="px-4 py-2 font-medium text-slate-800 border-b-2 border-slate-800">
                    Tagihan
                </button>
                <button onclick="switchTab('pembayaran')" id="tab-pembayaran" class="px-4 py-2 font-medium text-gray-500 border-b-2 border-transparent">
                    Verifikasi Pembayaran
                </button>
            </div>

            {{-- ================= TAB TAGIHAN ================= --}}
            <div id="panel-tagihan">
                <div class="flex justify-between items-center mb-4">
                    <p class="text-gray-500 text-sm">
                        Menampilkan <span id="tagihan-jumlah" class="font-semibold text-gray-700">{{ $tagihan->count() }}</span> dari {{ $tagihan->count() }} tagihan
                    </p>
                    <a href="{{ route('tagihan.create') }}" class="bg-gradient-to-r from-slate-800 to-slate-900 text-white px-5 py-2.5 rounded-full font-medium shadow-sm hover:opacity-90">
                        + Tambah Tagihan
                    </a>
                </div>

                {{-- Pencarian & filter --}}
                <div class="flex flex-col md:flex-row gap-3 mb-5">
                    <div class="relative flex-1">
                        <svg class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" /></svg>
                        <input id="tagihan-cari" type="text" oninput="applyFilter('tagihan')" placeholder="Cari nama penghuni..."
                            class="w-full pl-10 pr-4 py-2.5 rounded-2xl border-gray-200 bg-white shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-100">
                    </div>
                    <select id="tagihan-status" onchange="applyFilter('tagihan')"
                        class="rounded-2xl border-gray-200 bg-white shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-100">
                        <option value="">Semua Status</option>
                        <option value="lunas">Lunas</option>
                        <option value="belum">Belum Lunas</option>
                    </select>
                    <select id="tagihan-bulan" onchange="applyFilter('tagihan')"
                        class="rounded-2xl border-gray-200 bg-white shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-100">
                        <option value="">Semua Bulan</option>
                        @foreach ($bulanTagihan as $b)
                            <option value="{{ $b }}">{{ $namaBulan[substr($b, 5, 2)] }} {{ substr($b, 0, 4) }}</option>
                        @endforeach
                    </select>
                    <button type="button" onclick="resetFilter('tagihan')"
                        class="px-4 py-2.5 rounded-2xl bg-white border border-gray-200 shadow-sm text-sm font-medium text-slate-700 hover:bg-slate-100">
                        Reset
                    </button>
                </div>

                <div class="space-y-3">
                    @forelse ($tagihan as $item)
                        <div data-item
                             data-nama="{{ strtolower($item->penghuni->nama) }}"
                             data-status="{{ $item->status == 'lunas' ? 'lunas' : 'belum' }}"
                             data-bulan="{{ \Carbon\Carbon::parse($item->jatuh_tempo)->format('Y-m') }}">
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center justify-between gap-4 hover:shadow-md transition">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $item->penghuni->nama }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Jatuh tempo {{ \Carbon\Carbon::parse($item->jatuh_tempo)->format('d M Y') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-slate-700">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</p>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $item->status == 'lunas' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ $item->status == 'lunas' ? 'Lunas' : 'Belum Lunas' }}
                                    </span>
                                </div>
                                <div class="flex gap-2 shrink-0">
                                    <a href="{{ route('tagihan.edit', $item->id) }}" class="text-sm text-slate-700 font-medium bg-slate-100 px-3 py-2 rounded-lg hover:bg-slate-200">Edit</a>
                                    <form action="{{ route('tagihan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 font-medium bg-red-50 px-3 py-2 rounded-lg hover:bg-red-100">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center text-gray-500">Belum ada tagihan.</div>
                    @endforelse

                    <div id="tagihan-kosong" class="hidden bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center text-gray-500">
                        Tidak ada tagihan yang cocok dengan pencarianmu.
                    </div>
                </div>
            </div>

            {{-- ================= TAB PEMBAYARAN ================= --}}
            <div id="panel-pembayaran" class="hidden">
                <div class="flex justify-between items-center mb-4">
                    <p class="text-gray-500 text-sm">
                        Menampilkan <span id="pembayaran-jumlah" class="font-semibold text-gray-700">{{ $pembayaran->count() }}</span> dari {{ $pembayaran->count() }} pembayaran
                    </p>
                    <a href="{{ route('pembayaran.create') }}" class="bg-gradient-to-r from-slate-800 to-slate-900 text-white px-5 py-2.5 rounded-full font-medium shadow-sm hover:opacity-90">
                        + Catat Pembayaran
                    </a>
                </div>

                {{-- Pencarian & filter --}}
                <div class="flex flex-col md:flex-row gap-3 mb-5">
                    <div class="relative flex-1">
                        <svg class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" /></svg>
                        <input id="pembayaran-cari" type="text" oninput="applyFilter('pembayaran')" placeholder="Cari nama penghuni..."
                            class="w-full pl-10 pr-4 py-2.5 rounded-2xl border-gray-200 bg-white shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-100">
                    </div>
                    <select id="pembayaran-status" onchange="applyFilter('pembayaran')"
                        class="rounded-2xl border-gray-200 bg-white shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-100">
                        <option value="">Semua Status</option>
                        <option value="menunggu">Menunggu</option>
                        <option value="diterima">Diterima</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                    <select id="pembayaran-bulan" onchange="applyFilter('pembayaran')"
                        class="rounded-2xl border-gray-200 bg-white shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-100">
                        <option value="">Semua Bulan</option>
                        @foreach ($bulanPembayaran as $b)
                            <option value="{{ $b }}">{{ $namaBulan[substr($b, 5, 2)] }} {{ substr($b, 0, 4) }}</option>
                        @endforeach
                    </select>
                    <button type="button" onclick="resetFilter('pembayaran')"
                        class="px-4 py-2.5 rounded-2xl bg-white border border-gray-200 shadow-sm text-sm font-medium text-slate-700 hover:bg-slate-100">
                        Reset
                    </button>
                </div>

                <div class="space-y-3">
                    @forelse ($pembayaran as $item)
                        @php
                            $statusBayar = in_array($item->status_verifikasi, ['diterima', 'terverifikasi']) ? 'diterima'
                                : ($item->status_verifikasi == 'ditolak' ? 'ditolak' : 'menunggu');

                            $badgeColor = match($statusBayar) {
                                'diterima' => 'bg-emerald-100 text-emerald-700',
                                'ditolak' => 'bg-red-100 text-red-600',
                                default => 'bg-yellow-100 text-yellow-700',
                            };
                        @endphp
                        <div data-item
                             data-nama="{{ strtolower($item->tagihan->penghuni->nama) }}"
                             data-status="{{ $statusBayar }}"
                             data-bulan="{{ \Carbon\Carbon::parse($item->tanggal_bayar)->format('Y-m') }}">
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center justify-between gap-4 hover:shadow-md transition">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $item->tagihan->penghuni->nama }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ \Carbon\Carbon::parse($item->tanggal_bayar)->format('d M Y') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-slate-700">Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</p>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $badgeColor }}">{{ ucfirst($statusBayar) }}</span>
                                </div>
                                <div class="flex gap-2 shrink-0">
                                    <a href="{{ route('pembayaran.edit', $item->id) }}" class="text-sm text-slate-700 font-medium bg-slate-100 px-3 py-2 rounded-lg hover:bg-slate-200">Verifikasi</a>
                                    <form action="{{ route('pembayaran.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 font-medium bg-red-50 px-3 py-2 rounded-lg hover:bg-red-100">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center text-gray-500">Belum ada pembayaran.</div>
                    @endforelse

                    <div id="pembayaran-kosong" class="hidden bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center text-gray-500">
                        Tidak ada pembayaran yang cocok dengan pencarianmu.
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        function switchTab(tab) {
            document.getElementById('panel-tagihan').classList.toggle('hidden', tab !== 'tagihan');
            document.getElementById('panel-pembayaran').classList.toggle('hidden', tab !== 'pembayaran');

            document.getElementById('tab-tagihan').className = tab === 'tagihan'
                ? 'px-4 py-2 font-medium text-slate-800 border-b-2 border-slate-800'
                : 'px-4 py-2 font-medium text-gray-500 border-b-2 border-transparent';

            document.getElementById('tab-pembayaran').className = tab === 'pembayaran'
                ? 'px-4 py-2 font-medium text-slate-800 border-b-2 border-slate-800'
                : 'px-4 py-2 font-medium text-gray-500 border-b-2 border-transparent';
        }

        function applyFilter(kind) {
            const kata   = document.getElementById(kind + '-cari').value.trim().toLowerCase();
            const status = document.getElementById(kind + '-status').value;
            const bulan  = document.getElementById(kind + '-bulan').value;

            const items = document.querySelectorAll('#panel-' + kind + ' [data-item]');
            let tampil = 0;

            items.forEach(function (el) {
                const cocok =
                    (!kata   || el.dataset.nama.includes(kata)) &&
                    (!status || el.dataset.status === status) &&
                    (!bulan  || el.dataset.bulan === bulan);

                el.classList.toggle('hidden', !cocok);
                if (cocok) tampil++;
            });

            document.getElementById(kind + '-jumlah').textContent = tampil;
            document.getElementById(kind + '-kosong').classList.toggle('hidden', tampil !== 0 || items.length === 0);
        }

        function resetFilter(kind) {
            document.getElementById(kind + '-cari').value = '';
            document.getElementById(kind + '-status').value = '';
            document.getElementById(kind + '-bulan').value = '';
            applyFilter(kind);
        }
    </script>
    @endpush
</x-app-layout>