<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Properti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $properti = Properti::where('user_id', auth()->id())->with('admin')->get();
        return view('admin.index', compact('properti'));
    }

    public function create()
    {
        $properti = Properti::where('user_id', auth()->id())->get();
        return view('admin.create', compact('properti'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'properti_id' => 'required|exists:properties,id',
        ]);

        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $user->propertiDitugaskan()->attach($request->properti_id);

        return redirect()->route('admin.index')->with('success', 'Admin berhasil ditambahkan! Password default: password123');
    }

    public function destroy($userId, $propertiId)
    {
        $user = User::find($userId);
        $user->propertiDitugaskan()->detach($propertiId);

        return redirect()->route('admin.index')->with('success', 'Admin berhasil dihapus dari properti ini!');
    }
}