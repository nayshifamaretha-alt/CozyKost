<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Properti;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index()
    {
        $kamar = Kamar::whereHas('properti', function ($query) {
            $query->where('user_id', auth()->id());
        })->with('properti')->get();

        return view('kamar.index', compact('kamar'));
    }

    public function create()
    {
        $properti = Properti::where('user_id', auth()->id())->get();
        return view('kamar.create', compact('properti'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'properti_id' => 'required|exists:properties,id',
            'nomor_kamar' => 'required|string|max:255',
            'harga_sewa' => 'required|numeric',
            'fasilitas' => 'nullable|string',
        ]);

        Kamar::create($request->only('properti_id', 'nomor_kamar', 'harga_sewa', 'fasilitas'));

        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil ditambahkan!');
    }

    public function edit(Kamar $kamar)
    {
        $properti = Properti::where('user_id', auth()->id())->get();
        return view('kamar.edit', compact('kamar', 'properti'));
    }

    public function update(Request $request, Kamar $kamar)
    {
        $request->validate([
            'properti_id' => 'required|exists:properties,id',
            'nomor_kamar' => 'required|string|max:255',
            'harga_sewa' => 'required|numeric',
            'fasilitas' => 'nullable|string',
            'status' => 'required|in:kosong,terisi',
        ]);

        $kamar->update($request->only('properti_id', 'nomor_kamar', 'harga_sewa', 'fasilitas', 'status'));

        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil diperbarui!');
    }

    public function destroy(Kamar $kamar)
    {
        $kamar->delete();
        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil dihapus!');
    }
}