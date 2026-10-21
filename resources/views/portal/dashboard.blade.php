<x-app-layout>
<div class="p-10">
    <div class="mb-8">
        <h3 class="text-2xl font-bold text-gray-800">Halo, {{ $penghuni->nama }} 👋</h3>
        <p class="text-gray-500 text-sm mt-1">Berikut ringkasan kamar dan tagihan kamu</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="rounded-3xl p-6 text-white shadow-md bg-gradient-to-br from-slate-800 to-slate-900">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-5 h-5 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                <p class="text-sm opacity-90">Kamar Ditempati</p>
            </div>
            <h4 class="text-3xl font-bold">{{ $penghuni->kamar->nomor_kamar ?? '-' }}</h4>
            <p class="text-sm mt-1 opacity-90">{{ $penghuni->kamar->properti->nama_properti ?? '-' }}</p>
        </div>

        <div class="rounded-3xl p-6 bg-white shadow-sm border border-gray-100 hover:shadow-md transition">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m-6 4h6m-6 4h4M5 3h14a1 1 0 011 1v16l-3-2-3 2-3-2-3 2-3-2-3 2V4a1 1 0 011-1z" /></svg>
                <p class="text-sm text-gray-500">Tagihan Bulan Ini</p>
            </div>
            @if($tagihanBulanIni)
                <h4 class="text-2xl font-bold text-gray-800">Rp {{ number_format($tagihanBulanIni->jumlah, 0, ',', '.') }}</h4>
                <span class="inline-block mt-2 px-3 py-1 rounded-full text-xs font-semibold {{ $tagihanBulanIni->status == 'lunas' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                    {{ $tagihanBulanIni->status == 'lunas' ? 'Lunas' : 'Belum Lunas' }}
                </span>
                @if($tagihanBulanIni->status != 'lunas')
                    <a href="{{ route('portal.tagihan') }}" class="block mt-3 text-center bg-gradient-to-r from-slate-800 to-slate-900 text-white text-sm font-semibold px-4 py-2.5 rounded-2xl shadow-sm hover:shadow-md transition">
                        Bayar Sekarang
                    </a>
                @endif
            @else
                <p class="text-gray-400 text-sm mt-2">Belum ada tagihan bulan ini</p>
            @endif
        </div>

        <div class="rounded-3xl p-6 bg-white shadow-sm border border-gray-100 hover:shadow-md transition">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                <p class="text-sm text-gray-500">Komplain Terakhir</p>
            </div>
            @if($komplainTerakhir)
                <p class="font-semibold text-gray-800">{{ Str::limit($komplainTerakhir->deskripsi, 40) }}</p>
                <span class="inline-block mt-2 px-3 py-1 rounded-full text-xs font-semibold {{ $komplainTerakhir->status == 'selesai' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                    {{ ucfirst($komplainTerakhir->status) }}
                </span>
            @else
                <p class="text-gray-400 text-sm mt-2">Belum ada komplain</p>
            @endif
        </div>
    </div>

    <div class="mt-10">
        <h5 class="text-lg font-bold text-gray-800 mb-4">Riwayat Pembayaran Terakhir</h5>
        <div class="space-y-3">
            @forelse($riwayatPembayaran as $bayar)
                <div class="rounded-2xl p-5 bg-white shadow-sm border border-gray-100 hover:shadow-md transition flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-gray-800">Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-400">{{ \Carbon\Carbon::parse($bayar->tanggal_bayar)->format('d M Y') }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ in_array($bayar->status_verifikasi, ['terverifikasi', 'diterima']) ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                        {{ in_array($bayar->status_verifikasi, ['terverifikasi', 'diterima']) ? 'Terverifikasi' : ucfirst($bayar->status_verifikasi) }}
                    </span>
                </div>
            @empty
                <div class="rounded-2xl p-8 bg-white shadow-sm border border-gray-100 text-center">
                    <p class="text-gray-400 text-sm">Belum ada riwayat pembayaran</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
</x-app-layout>