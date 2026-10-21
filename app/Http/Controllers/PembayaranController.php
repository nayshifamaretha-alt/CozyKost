<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayaran = Pembayaran::whereHas('tagihan.penghuni.kamar.properti', function ($query) {
            $query->where('user_id', auth()->id());
        })->with('tagihan.penghuni')->latest()->get();

        return view('pembayaran.index', compact('pembayaran'));
    }

    public function create()
    {
        $tagihan = Tagihan::whereHas('penghuni.kamar.properti', function ($query) {
            $query->where('user_id', auth()->id());
        })->where('status', 'belum_lunas')->with('penghuni')->get();

        return view('pembayaran.create', compact('tagihan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tagihan_id' => 'required|exists:tagihans,id',
            'jumlah_bayar' => 'required|numeric',
            'tanggal_bayar' => 'required|date',
        ]);

        Pembayaran::create($request->only('tagihan_id', 'jumlah_bayar', 'tanggal_bayar'));

        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil dicatat, menunggu verifikasi!');
    }

    public function edit(Pembayaran $pembayaran)
    {
        return view('pembayaran.edit', compact('pembayaran'));
    }

    public function update(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:menunggu,diterima,ditolak',
        ]);

        $pembayaran->update($request->only('status_verifikasi'));

        if ($request->status_verifikasi == 'diterima') {
            $pembayaran->tagihan->update(['status' => 'lunas']);
        }

        return redirect()->route('pembayaran.index')->with('success', 'Status pembayaran berhasil diperbarui!');
    }

    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();
        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil dihapus!');
    }
}