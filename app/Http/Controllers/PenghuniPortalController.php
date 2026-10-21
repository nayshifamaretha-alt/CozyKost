<?php

namespace App\Http\Controllers;

use App\Models\Penghuni;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\Komplain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenghuniPortalController extends Controller
{
    private function penghuniAktif()
    {
        return Penghuni::where('user_id', Auth::id())->firstOrFail();
    }

    public function dashboard()
    {
        $penghuni = $this->penghuniAktif();

        $tagihanBulanIni = Tagihan::where('penghuni_id', $penghuni->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->latest()
            ->first();

        $riwayatPembayaran = Pembayaran::whereHas('tagihan', function ($q) use ($penghuni) {
                $q->where('penghuni_id', $penghuni->id);
            })
            ->latest()
            ->take(3)
            ->get();

        $komplainTerakhir = Komplain::where('penghuni_id', $penghuni->id)
            ->latest()
            ->first();

        return view('portal.dashboard', compact(
            'penghuni', 'tagihanBulanIni', 'riwayatPembayaran', 'komplainTerakhir'
        ));
    }

    public function tagihan()
    {
        $penghuni = $this->penghuniAktif();
        $tagihans = Tagihan::where('penghuni_id', $penghuni->id)->latest()->get();
        return view('portal.tagihan', compact('tagihans'));
    }

    public function bayar(Request $request, $tagihanId)
    {
        $penghuni = $this->penghuniAktif();

        $tagihan = Tagihan::where('id', $tagihanId)
            ->where('penghuni_id', $penghuni->id)
            ->firstOrFail();

        $request->validate([
            'jumlah_bayar'   => 'required|numeric|min:1',
            'bukti_transfer' => 'nullable|image|max:2048',
        ]);

        $buktiPath = null;
        if ($request->hasFile('bukti_transfer')) {
            $buktiPath = $request->file('bukti_transfer')->store('bukti-pembayaran', 'public');
        }

        Pembayaran::create([
            'tagihan_id'        => $tagihan->id,
            'jumlah_bayar'      => $request->jumlah_bayar,
            'bukti_transfer'    => $buktiPath,
            'tanggal_bayar'     => now(),
            'status_verifikasi' => 'menunggu',
        ]);

        return redirect()->route('portal.tagihan')->with('success', 'Pembayaran berhasil dikirim, menunggu verifikasi admin.');
    }

    public function komplainIndex()
    {
        $penghuni = $this->penghuniAktif();
        $komplains = Komplain::where('penghuni_id', $penghuni->id)->latest()->get();
        return view('portal.komplain', compact('komplains'));
    }

    public function komplainStore(Request $request)
    {
        $penghuni = $this->penghuniAktif();

        $request->validate([
            'deskripsi' => 'required|string|max:500',
            'prioritas' => 'nullable|in:rendah,sedang,tinggi',
        ]);

        Komplain::create([
            'penghuni_id' => $penghuni->id,
            'deskripsi'   => $request->deskripsi,
            'prioritas'   => $request->prioritas ?? 'sedang',
            'status'      => 'diproses',
        ]);

        return redirect()->route('portal.komplain')->with('success', 'Komplain berhasil dikirim.');
    }
}