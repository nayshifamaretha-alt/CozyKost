<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = now()->subMonths($i);
            $total = Tagihan::whereHas('penghuni.kamar.properti', fn($q) => $q->where('user_id', $userId))
                ->where('status', 'lunas')
                ->whereMonth('created_at', $bulan->month)
                ->whereYear('created_at', $bulan->year)
                ->sum('jumlah');

            $data[] = [
                'label' => $bulan->translatedFormat('M Y'),
                'total' => $total,
            ];
        }

        return view('laporan.index', compact('data'));
    }
}