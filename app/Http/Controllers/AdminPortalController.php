<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\Pembayaran;
use App\Models\Komplain;

class AdminPortalController extends Controller
{
    public function dashboard()
    {
        $properti = auth()->user()->propertiDitugaskan;
        $propertiIds = $properti->pluck('id');

        $totalKamar = Kamar::whereIn('properti_id', $propertiIds)->count();
        $kamarTerisi = Kamar::whereIn('properti_id', $propertiIds)->where('status', 'terisi')->count();

        return view('adminportal.dashboard', compact('properti', 'totalKamar', 'kamarTerisi'));
    }

    public function kamar()
    {
        $propertiIds = auth()->user()->propertiDitugaskan->pluck('id');
        $kamar = Kamar::whereIn('properti_id', $propertiIds)->with('properti')->get();

        return view('adminportal.kamar', compact('kamar'));
    }

    public function penghuni()
    {
        $propertiIds = auth()->user()->propertiDitugaskan->pluck('id');
        $penghuni = Penghuni::whereHas('kamar', fn($q) => $q->whereIn('properti_id', $propertiIds))->with('kamar')->get();

        return view('adminportal.penghuni', compact('penghuni'));
    }

    public function pembayaran()
    {
        $propertiIds = auth()->user()->propertiDitugaskan->pluck('id');
        $pembayaran = Pembayaran::whereHas('tagihan.penghuni.kamar', fn($q) => $q->whereIn('properti_id', $propertiIds))
            ->with('tagihan.penghuni')->latest()->get();

        return view('adminportal.pembayaran', compact('pembayaran'));
    }

    public function verifikasiPembayaran(Pembayaran $pembayaran)
    {
        $pembayaran->update(['status_verifikasi' => 'diterima']);
        $pembayaran->tagihan->update(['status' => 'lunas']);

        return redirect()->route('adminportal.pembayaran')->with('success', 'Pembayaran berhasil diverifikasi!');
    }

    public function komplain()
    {
        $propertiIds = auth()->user()->propertiDitugaskan->pluck('id');
        $komplain = Komplain::whereHas('penghuni.kamar', fn($q) => $q->whereIn('properti_id', $propertiIds))
            ->with('penghuni')->latest()->get();

        return view('adminportal.komplain', compact('komplain'));
    }

    public function selesaikanKomplain(Komplain $komplain)
    {
        $komplain->update(['status' => 'selesai']);
        return redirect()->route('adminportal.komplain')->with('success', 'Komplain ditandai selesai!');
    }
}