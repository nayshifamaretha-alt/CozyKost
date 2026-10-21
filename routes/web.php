<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertiController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\PenghuniController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\KomplainController;
use App\Http\Controllers\PenghuniPortalController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPortalController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MonitoringController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role == 'penghuni') {
        return redirect()->route('portal.dashboard');
    }

    if (auth()->user()->role == 'admin') {
        return redirect()->route('adminportal.dashboard');
    }

    $userId = auth()->id();

    $totalKamar = \App\Models\Kamar::whereHas('properti', fn($q) => $q->where('user_id', $userId))->count();
    $kamarTerisi = \App\Models\Kamar::whereHas('properti', fn($q) => $q->where('user_id', $userId))->where('status', 'terisi')->count();
    $pendapatan = \App\Models\Tagihan::whereHas('penghuni.kamar.properti', fn($q) => $q->where('user_id', $userId))
        ->where('status', 'lunas')
        ->whereMonth('created_at', now()->month)
        ->sum('jumlah');
    $daftarKamar = \App\Models\Kamar::whereHas('properti', fn($q) => $q->where('user_id', $userId))->with('properti')->get();

    return view('dashboard', compact('totalKamar', 'kamarTerisi', 'pendapatan', 'daftarKamar'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:pemilik')->group(function () {
        Route::resource('properti', PropertiController::class);
        Route::resource('kamar', KamarController::class);
        Route::resource('penghuni', PenghuniController::class);
        Route::resource('tagihan', TagihanController::class);
        Route::resource('pembayaran', PembayaranController::class);
        Route::resource('komplain', KomplainController::class);

        Route::get('/keuangan', [\App\Http\Controllers\KeuanganController::class, 'index'])->name('keuangan.index');

        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

        Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');

        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
        Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
        Route::delete('/admin/{userId}/{propertiId}', [AdminController::class, 'destroy'])->name('admin.destroy');
    });

    Route::middleware('role:penghuni')->prefix('portal')->name('portal.')->group(function () {
        Route::get('/dashboard', [PenghuniPortalController::class, 'dashboard'])->name('dashboard');
        Route::get('/tagihan', [PenghuniPortalController::class, 'tagihan'])->name('tagihan');
        Route::post('/tagihan/{tagihanId}/bayar', [PenghuniPortalController::class, 'bayar'])->name('bayar');
        Route::get('/komplain', [PenghuniPortalController::class, 'komplainIndex'])->name('komplain');
        Route::post('/komplain', [PenghuniPortalController::class, 'komplainStore'])->name('komplain.store');
    });

    Route::middleware('role:admin')->prefix('adminportal')->name('adminportal.')->group(function () {
        Route::get('/dashboard', [AdminPortalController::class, 'dashboard'])->name('dashboard');
        Route::get('/kamar', [AdminPortalController::class, 'kamar'])->name('kamar');
        Route::get('/penghuni', [AdminPortalController::class, 'penghuni'])->name('penghuni');
        Route::get('/pembayaran', [AdminPortalController::class, 'pembayaran'])->name('pembayaran');
        Route::post('/pembayaran/{pembayaran}/verifikasi', [AdminPortalController::class, 'verifikasiPembayaran'])->name('pembayaran.verifikasi');
        Route::get('/komplain', [AdminPortalController::class, 'komplain'])->name('komplain');
        Route::post('/komplain/{komplain}/selesai', [AdminPortalController::class, 'selesaikanKomplain'])->name('komplain.selesai');
    });
});

require __DIR__.'/auth.php';