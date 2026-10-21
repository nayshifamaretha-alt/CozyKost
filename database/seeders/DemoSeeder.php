<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Properti;
use App\Models\Kamar;
use App\Models\Penghuni;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user pertama sebagai pemilik, atau bikin baru kalau belum ada
        $user = User::first() ?? User::create([
            'name' => 'Demo Pemilik',
            'email' => 'demo@kosku.com',
            'password' => Hash::make('password'),
            'role' => 'pemilik',
        ]);

        $properti = Properti::create([
            'user_id' => $user->id,
            'nama_properti' => 'Kos Melati Indah',
            'alamat' => 'Jl. Melati No. 10, Surabaya',
            'deskripsi' => 'Kos nyaman dekat kampus',
        ]);

        $kamar1 = Kamar::create([
            'properti_id' => $properti->id,
            'nomor_kamar' => '101',
            'harga_sewa' => 1200000,
            'fasilitas' => 'AC, Kamar Mandi Dalam, WiFi',
            'status' => 'kosong',
        ]);

        $kamar2 = Kamar::create([
            'properti_id' => $properti->id,
            'nomor_kamar' => '102',
            'harga_sewa' => 1000000,
            'fasilitas' => 'Kipas Angin, WiFi',
            'status' => 'kosong',
        ]);

        Kamar::create([
            'properti_id' => $properti->id,
            'nomor_kamar' => '103',
            'harga_sewa' => 1500000,
            'fasilitas' => 'AC, Kamar Mandi Dalam, WiFi, TV',
            'status' => 'kosong',
        ]);

        Penghuni::create([
            'kamar_id' => $kamar1->id,
            'nama' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'no_hp' => '081234567890',
            'tanggal_masuk' => now()->subMonths(2),
            'status' => 'aktif',
        ]);
        $kamar1->update(['status' => 'terisi']);

        Penghuni::create([
            'kamar_id' => $kamar2->id,
            'nama' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'no_hp' => '081298765432',
            'tanggal_masuk' => now()->subMonth(),
            'status' => 'aktif',
        ]);
        $kamar2->update(['status' => 'terisi']);
    }
}