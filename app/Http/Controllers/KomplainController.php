<?php

namespace App\Http\Controllers;

use App\Models\Komplain;
use App\Models\Penghuni;
use Illuminate\Http\Request;

class KomplainController extends Controller
{
    public function index()
    {
        $komplain = Komplain::whereHas('penghuni.kamar.properti', function ($query) {
            $query->where('user_id', auth()->id());
        })->with('penghuni')->latest()->get();

        return view('komplain.index', compact('komplain'));
    }

    public function create()
    {
        $penghuni = Penghuni::whereHas('kamar.properti', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();

        return view('komplain.create', compact('penghuni'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'penghuni_id' => 'required|exists:penghunis,id',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
        ]);

        Komplain::create($request->only('penghuni_id', 'kategori', 'deskripsi', 'prioritas'));

        return redirect()->route('komplain.index')->with('success', 'Komplain berhasil dicatat!');
    }

    public function edit(Komplain $komplain)
    {
        return view('komplain.edit', compact('komplain'));
    }

    public function update(Request $request, Komplain $komplain)
    {
        $request->validate([
            'status' => 'required|in:diproses,selesai',
        ]);

        $komplain->update($request->only('status'));

        return redirect()->route('komplain.index')->with('success', 'Status komplain berhasil diperbarui!');
    }

    public function destroy(Komplain $komplain)
    {
        $komplain->delete();
        return redirect()->route('komplain.index')->with('success', 'Komplain berhasil dihapus!');
    }
}