@php
    $namaBulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                  7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
    $bulanPendek = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
                    7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'];
    $fmtTgl = fn ($d) => $d->day . ' ' . $bulanPendek[$d->month] . ' ' . $d->year;

    $norm = fn ($s) => in_array($s, ['diterima', 'terverifikasi']) ? 'diterima' : ($s == 'ditolak' ? 'ditolak' : 'menunggu');

    $pembayaranMap = \App\Models\Pembayaran::whereIn('tagihan_id', $tagihans->pluck('id'))->get()->groupBy('tagihan_id');
    $hariIni = \Carbon\Carbon::today();

    $daftar = $tagihans->map(function ($t) use ($pembayaranMap, $norm, $namaBulan, $hariIni) {
        $jatuh = \Carbon\Carbon::parse($t->jatuh_tempo ?? $t->created_at)->startOfDay();
        $bayar = $pembayaranMap->get($t->id, collect())->sortByDesc('tanggal_bayar')->values();
        $lunas = $t->status == 'lunas';
        $diterima = $bayar->first(fn ($p) => $norm($p->status_verifikasi) == 'diterima');
        $menunggu = $bayar->contains(fn ($p) => $norm($p->status_verifikasi) == 'menunggu');
        $ditolak = ! $lunas && ! $menunggu && $bayar->isNotEmpty() && $norm($bayar->first()->status_verifikasi) == 'ditolak';
        $telat = ! $lunas && ! $menunggu && $jatuh->lt($hariIni);

        return (object) [
            'id' => $t->id,
            'jumlah' => $t->jumlah,
            'lunas' => $lunas,
            'menunggu' => $menunggu,
            'ditolak' => $ditolak,
            'telat' => $telat,
            'hari_telat' => $telat ? (int) floor(($hariIni->timestamp - $jatuh->timestamp) / 86400) : 0,
            'jatuh' => $jatuh,
            'label' => $namaBulan[$jatuh->month] . ' ' . $jatuh->year,
            'tgl_bayar' => $diterima ? \Carbon\Carbon::parse($diterima->tanggal_bayar) : null,
        ];
    })->sort(function ($a, $b) {
        return [$a->lunas ? 1 : 0, -$a->jatuh->timestamp] <=> [$b->lunas ? 1 : 0, -$b->jatuh->timestamp];
    })->values();

    $belum = $daftar->where('lunas', false);
    $sisa = $belum->sum('jumlah');
    $jmlBelum = $belum->count();
    $jmlMenunggu = $belum->where('menunggu', true)->count();
    $jmlTelat = $belum->where('telat', true)->count();
    $lunasList = $daftar->where('lunas', true);
@endphp

<x-app-layout>
<div class="p-10 max-w-5xl">

    {{-- Judul --}}
    <div class="flex items-center gap-3 mb-8">
        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center text-white shadow-md">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m-6 4h6m-6 4h4M5 3h14a1 1 0 011 1v16l-3-2-3 2-3-2-3 2-3-2-3 2V4a1 1 0 011-1z" /></svg>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-gray-800">Tagihan Saya</h3>
            <p class="text-gray-500 text-sm">Pantau dan bayar tagihan kos kamu di sini.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-5 rounded-2xl bg-green-50 border border-green-200 text-green-700 px-5 py-3 text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    {{-- Peringatan terlambat --}}
    @if ($jmlTelat > 0)
        <div class="mb-5 rounded-2xl bg-red-50 border border-red-200 text-red-700 px-5 py-3 text-sm font-medium">
            Ada {{ $jmlTelat }} tagihan yang sudah lewat jatuh tempo. Segera lakukan pembayaran ya.
        </div>
    @endif

    {{-- Ringkasan --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="rounded-3xl p-6 text-white shadow-md bg-gradient-to-br from-slate-800 to-slate-900">
            <p class="text-sm text-slate-300 font-medium">Total yang Harus Dibayar</p>
            <p class="text-2xl font-bold mt-1">Rp {{ number_format($sisa, 0, ',', '.') }}</p>
            <p class="text-xs text-slate-300 mt-2">
                {{ $jmlBelum > 0 ? $jmlBelum . ' tagihan belum lunas' : 'Semua tagihan sudah lunas 🎉' }}
            </p>
        </div>

        <div class="rounded-3xl p-6 bg-amber-50 border border-amber-100">
            <p class="text-sm text-amber-700 font-medium">Menunggu Verifikasi</p>
            <p class="text-3xl font-bold text-amber-800 mt-1">{{ $jmlMenunggu }}</p>
            <p class="text-xs text-amber-700 mt-2">Pembayaran yang sedang dicek admin</p>
        </div>

        <div class="rounded-3xl p-6 bg-white border border-gray-100 shadow-sm">
            <p class="text-sm text-gray-500 font-medium">Sudah Lunas</p>
            <p class="text-3xl font-bold text-gray-800 mt-1">{{ $lunasList->count() }}</p>
            <p class="text-xs text-gray-500 mt-2">Total Rp {{ number_format($lunasList->sum('jumlah'), 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Pencarian dan filter --}}
    <div class="flex flex-col md:flex-row gap-3 mb-4">
        <div class="relative flex-1">
            <svg class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" /></svg>
            <input id="cari" type="text" oninput="terapkanFilter()" placeholder="Cari bulan atau nominal, misalnya Agustus..."
                class="w-full pl-10 pr-4 py-2.5 rounded-2xl border-gray-200 bg-white shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-100">
        </div>
        <select id="status" onchange="terapkanFilter()"
            class="rounded-2xl border-gray-200 bg-white shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-100">
            <option value="">Semua Status</option>
            <option value="belum">Belum Lunas</option>
            <option value="lunas">Lunas</option>
        </select>
        <button type="button" onclick="resetFilter()"
            class="px-4 py-2.5 rounded-2xl bg-white border border-gray-200 shadow-sm text-sm font-medium text-slate-700 hover:bg-slate-100">
            Reset
        </button>
    </div>

    <p class="text-gray-500 text-sm mb-5">
        Menampilkan <span id="jumlah" class="font-semibold text-gray-700">{{ $daftar->count() }}</span> dari {{ $daftar->count() }} tagihan
    </p>

    {{-- Daftar tagihan --}}
    <div class="space-y-4">
        @forelse ($daftar as $d)
            @php
                $punyaError = $errors->any() && old('tagihan_ref') == $d->id;
            @endphp

            <div data-item
                 data-cari="{{ strtolower($d->label . ' ' . $d->jumlah) }}"
                 data-status="{{ $d->lunas ? 'lunas' : 'belum' }}"
                 class="rounded-3xl p-6 bg-white shadow-sm border border-gray-100 hover:shadow-md transition">

                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Tagihan {{ $d->label }}</p>
                        <h5 class="text-xl font-bold text-gray-800 mt-0.5">Rp {{ number_format($d->jumlah, 0, ',', '.') }}</h5>
                        <p class="text-xs text-gray-400 mt-1">
                            Jatuh tempo {{ $fmtTgl($d->jatuh) }}
                            @if ($d->lunas && $d->tgl_bayar)
                                · Dibayar {{ $fmtTgl($d->tgl_bayar) }}
                            @elseif ($d->telat)
                                · <span class="text-red-500 font-medium">Lewat {{ $d->hari_telat }} hari</span>
                            @endif
                        </p>
                    </div>

                    @if ($d->lunas)
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Lunas</span>
                    @elseif ($d->menunggu)
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">Menunggu Verifikasi</span>
                    @elseif ($d->telat)
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-600">Terlambat</span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">Belum Lunas</span>
                    @endif
                </div>

                @if (! $d->lunas)
                    <div class="mt-5 pt-5 border-t border-gray-100">
                        @if ($d->menunggu)
                            <div class="rounded-2xl bg-yellow-50 border border-yellow-100 px-4 py-3 text-sm text-yellow-800">
                                Pembayaranmu sudah dikirim dan sedang menunggu verifikasi admin.
                            </div>
                        @else
                            @if ($d->ditolak)
                                <div class="rounded-2xl bg-red-50 border border-red-100 px-4 py-3 text-sm text-red-700 mb-4">
                                    Pembayaran sebelumnya ditolak. Silakan kirim ulang dengan bukti transfer yang jelas.
                                </div>
                            @endif

                            <button type="button" onclick="toggleBayar({{ $d->id }})"
                                class="bg-gradient-to-r from-slate-800 to-slate-900 text-white text-sm font-semibold px-5 py-2.5 rounded-2xl shadow-sm hover:shadow-md transition">
                                Bayar Sekarang
                            </button>

                            <form id="form-bayar-{{ $d->id }}" action="{{ route('portal.bayar', $d->id) }}" method="POST" enctype="multipart/form-data"
                                class="{{ $punyaError ? '' : 'hidden' }} mt-4">
                                @csrf
                                <input type="hidden" name="tagihan_ref" value="{{ $d->id }}">

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 mb-1.5">Jumlah Bayar</label>
                                        <input type="number" name="jumlah_bayar" value="{{ $d->jumlah }}" required
                                            class="w-full rounded-2xl border-gray-200 bg-gray-50 focus:bg-white focus:border-slate-400 focus:ring-2 focus:ring-slate-100 transition">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 mb-1.5">Bukti Transfer (opsional)</label>
                                        <input type="file" name="bukti_transfer" accept="image/*"
                                            class="w-full text-sm text-gray-500 file:mr-3 file:rounded-xl file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-sm file:font-medium file:text-slate-700 hover:file:bg-slate-200">
                                    </div>
                                    <div class="flex items-end">
                                        <button type="submit"
                                            class="w-full bg-gradient-to-r from-slate-800 to-slate-900 text-white font-semibold px-4 py-2.5 rounded-2xl shadow-md hover:shadow-lg transition-all">
                                            Kirim Pembayaran
                                        </button>
                                    </div>
                                </div>

                                @if ($punyaError)
                                    @error('jumlah_bayar') <p class="text-red-500 text-sm mt-2">{{ $message }}</p> @enderror
                                    @error('bukti_transfer') <p class="text-red-500 text-sm mt-2">{{ $message }}</p> @enderror
                                @endif
                            </form>
                        @endif
                    </div>
                @endif
            </div>
        @empty
            <div class="rounded-2xl p-10 bg-white shadow-sm border border-gray-100 text-center">
                <p class="text-gray-400 text-sm">Belum ada tagihan</p>
            </div>
        @endforelse

        <div id="kosong" class="hidden rounded-2xl p-10 bg-white shadow-sm border border-gray-100 text-center">
            <p class="text-gray-400 text-sm">Tidak ada tagihan yang cocok dengan pencarianmu.</p>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggleBayar(id) {
        document.getElementById('form-bayar-' + id).classList.toggle('hidden');
    }

    function terapkanFilter() {
        const kata = document.getElementById('cari').value.trim().toLowerCase();
        const status = document.getElementById('status').value;
        const items = document.querySelectorAll('[data-item]');
        let tampil = 0;

        items.forEach(function (el) {
            const cocok = (!kata || el.dataset.cari.includes(kata))
                && (!status || el.dataset.status === status);
            el.classList.toggle('hidden', !cocok);
            if (cocok) tampil++;
        });

        document.getElementById('jumlah').textContent = tampil;
        document.getElementById('kosong').classList.toggle('hidden', tampil !== 0 || items.length === 0);
    }

    function resetFilter() {
        document.getElementById('cari').value = '';
        document.getElementById('status').value = '';
        terapkanFilter();
    }
</script>
@endpush
</x-app-layout>