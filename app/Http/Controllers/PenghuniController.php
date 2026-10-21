<?php

namespace App\Http\Controllers;

use App\Models\Penghuni;
use App\Models\Kamar;
use Illuminate\Http\Request;

class PenghuniController extends Controller
{
    public function index()
    {
        $penghuni = Penghuni::whereHas('kamar.properti', function ($query) {
            $query->where('user_id', auth()->id());
        })->with('kamar')->get();

        return view('penghuni.index', compact('penghuni'));
    }

    public function create()
    {
        $kamar = Kamar::whereHas('properti', function ($query) {
            $query->where('user_id', auth()->id());
        })->where('status', 'kosong')->get();

        return view('penghuni.create', compact('kamar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kamar_id' => 'required|exists:kamars,id',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'no_hp' => 'required|string|max:20',
            'tanggal_masuk' => 'required|date',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'penghuni',
        ]);

        Penghuni::create([
            'user_id' => $user->id,
            'kamar_id' => $request->kamar_id,
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'tanggal_masuk' => $request->tanggal_masuk,
        ]);

        Kamar::where('id', $request->kamar_id)->update(['status' => 'terisi']);

        return redirect()->route('penghuni.index')->with('success', 'Penghuni berhasil ditambahkan! Password default: password123');
    }

    public function edit(Penghuni $penghuni)
    {
        $kamar = Kamar::whereHas('properti', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();

        return view('penghuni.edit', compact('penghuni', 'kamar'));
    }

    public function update(Request $request, Penghuni $penghuni)
    {
        $request->validate([
            'kamar_id' => 'required|exists:kamars,id',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'required|string|max:20',
            'tanggal_masuk' => 'required|date',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $penghuni->update($request->only('kamar_id', 'nama', 'email', 'no_hp', 'tanggal_masuk', 'status'));

        return redirect()->route('penghuni.index')->with('success', 'Penghuni berhasil diperbarui!');
    }

    public function destroy(Penghuni $penghuni)
    {
        Kamar::where('id', $penghuni->kamar_id)->update(['status' => 'kosong']);
        $penghuni->delete();

        return redirect()->route('penghuni.index')->with('success', 'Penghuni berhasil dihapus!');
    }
}