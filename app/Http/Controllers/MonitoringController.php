<?php

namespace App\Http\Controllers;

use App\Models\Properti;
use App\Models\Kamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        $properti = Properti::where('user_id', $userId)->get();

        $query = Kamar::whereHas('properti', fn($q) => $q->where('user_id', $userId))
            ->with(['properti', 'penghuni']);

        if ($request->filled('properti_id')) {
            $query->where('properti_id', $request->properti_id);
        }

        $kamar = $query->orderBy('properti_id')->orderBy('nomor_kamar')->get();

        return view('monitoring', compact('properti', 'kamar'));
    }
}