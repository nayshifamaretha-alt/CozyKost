<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Penghuni;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    public function index()
    {
        $tagihan = Tagihan::whereHas('penghuni.kamar.properti', function ($query) {
            $query->where('user_id', auth()->id());
        })->with('penghuni')->latest()->get();

        return view('tagihan.index', compact('tagihan'));
    }

    public function create()
    {
        $penghuni = Penghuni::whereHas('kamar.properti', function ($query) {
            $query->where('user_id', auth()->id());
        })->where('status', 'aktif')->get();

        return view('tagihan.create', compact('penghuni'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'penghuni_id' => 'required|exists:penghunis,id',
            'jumlah' => 'required|numeric',
            'jatuh_tempo' => 'required|date',
        ]);

        Tagihan::create($request->only('penghuni_id', 'jumlah', 'jatuh_tempo'));

        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil ditambahkan!');
    }

    public function edit(Tagihan $tagihan)
    {
        $penghuni = Penghuni::whereHas('kamar.properti', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();

        return view('tagihan.edit', compact('tagihan', 'penghuni'));
    }

    public function update(Request $request, Tagihan $tagihan)
    {
        $request->validate([
            'penghuni_id' => 'required|exists:penghunis,id',
            'jumlah' => 'required|numeric',
            'jatuh_tempo' => 'required|date',
            'status' => 'required|in:belum_lunas,lunas',
        ]);

        $tagihan->update($request->only('penghuni_id', 'jumlah', 'jatuh_tempo', 'status'));

        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil diperbarui!');
    }

    public function destroy(Tagihan $tagihan)
    {
        $tagihan->delete();
        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil dihapus!');
    }
}