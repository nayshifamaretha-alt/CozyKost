<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Pembayaran;

class KeuanganController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $tagihan = Tagihan::whereHas('penghuni.kamar.properti', fn($q) => $q->where('user_id', $userId))
            ->with('penghuni')->latest()->get();

        $pembayaran = Pembayaran::whereHas('tagihan.penghuni.kamar.properti', fn($q) => $q->where('user_id', $userId))
            ->with('tagihan.penghuni')->latest()->get();

        return view('keuangan.index', compact('tagihan', 'pembayaran'));
    }
}