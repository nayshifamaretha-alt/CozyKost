<?php

namespace App\Http\Controllers;

use App\Models\Properti;
use Illuminate\Http\Request;

class PropertiController extends Controller
{
    public function index()
    {
        $properti = Properti::where('user_id', auth()->id())->get();
        return view('properti.index', compact('properti'));
    }

    public function create()
    {
        return view('properti.create');
    }

        public function store(Request $request)
    {
        $request->validate([
            'nama_properti' => 'required|string|max:255',
            'alamat' => 'required|string',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('properti', 'public');
        }

        Properti::create([
            'user_id' => auth()->id(),
            'nama_properti' => $request->nama_properti,
            'alamat' => $request->alamat,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('properti.index')->with('success', 'Properti berhasil ditambahkan!');
    }

    public function edit(Properti $properti)
    {
        return view('properti.edit', compact('properti'));
    }

        public function update(Request $request, Properti $properti)
    {
        $request->validate([
            'nama_properti' => 'required|string|max:255',
            'alamat' => 'required|string',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('nama_properti', 'alamat', 'deskripsi');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('properti', 'public');
        }

        $properti->update($data);

        return redirect()->route('properti.index')->with('success', 'Properti berhasil diperbarui!');
    }
    public function destroy(Properti $properti)
    {
        $properti->delete();
        return redirect()->route('properti.index')->with('success', 'Properti berhasil dihapus!');
    }
}