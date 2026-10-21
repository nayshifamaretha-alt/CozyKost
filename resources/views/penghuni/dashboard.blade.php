@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold">Halo, {{ $penghuni->nama }} 👋</h3>
    <p class="text-muted">Berikut ringkasan kamar dan tagihan kamu</p>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card border-0 rounded-4 shadow-sm p-3" style="background: linear-gradient(135deg,#a78bfa,#f472b6); color:#fff;">
            <small>Kamar Ditempati</small>
            <h4 class="fw-bold mt-1">{{ $penghuni->kamar->nomor_kamar ?? '-' }}</h4>
            <p class="mb-0">{{ $penghuni->kamar->properti->nama_properti ?? '-' }}</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 rounded-4 shadow-sm p-3">
            <small class="text-muted">Tagihan Bulan Ini</small>
            @if($tagihanBulanIni)
                <h4 class="fw-bold mt-1">Rp {{ number_format($tagihanBulanIni->jumlah_tagihan, 0, ',', '.') }}</h4>
                <span class="badge rounded-pill {{ $tagihanBulanIni->status == 'lunas' ? 'bg-success' : 'bg-warning text-dark' }}">
                    {{ ucfirst($tagihanBulanIni->status) }}
                </span>
                @if($tagihanBulanIni->status != 'lunas')
                    <a href="{{ route('penghuni.tagihan.bayar', $tagihanBulanIni->id) }}" class="btn btn-sm btn-dark rounded-pill mt-2">Bayar Sekarang</a>
                @endif
            @else
                <p class="text-muted mb-0">Belum ada tagihan bulan ini</p>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 rounded-4 shadow-sm p-3">
            <small class="text-muted">Komplain Terakhir</small>
            @if($komplainTerakhir)
                <p class="fw-semibold mt-1 mb-1">{{ Str::limit($komplainTerakhir->deskripsi, 40) }}</p>
                <span class="badge rounded-pill bg-info text-dark">{{ ucfirst($komplainTerakhir->status) }}</span>
            @else
                <p class="text-muted mb-0">Belum ada komplain</p>
            @endif
        </div>
    </div>
</div>

<div class="mt-4">
    <h5 class="fw-bold mb-3">Riwayat Pembayaran Terakhir</h5>
    @forelse($riwayatPembayaran as $bayar)
        <div class="card border-0 rounded-4 shadow-sm p-3 mb-2 d-flex flex-row justify-content-between align-items-center">
            <div>
                <p class="mb-0 fw-semibold">Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}</p>
                <small class="text-muted">{{ $bayar->tanggal_bayar }}</small>
            </div>
            <span class="badge rounded-pill {{ $bayar->status_verifikasi == 'terverifikasi' ? 'bg-success' : 'bg-secondary' }}">
                {{ ucfirst($bayar->status_verifikasi) }}
            </span>
        </div>
    @empty
        <p class="text-muted">Belum ada riwayat pembayaran</p>
    @endforelse
</div>
@endsection