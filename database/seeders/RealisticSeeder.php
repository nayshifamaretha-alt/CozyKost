<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Properti;
use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\Komplain;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RealisticSeeder extends Seeder
{
    public function run(): void
    {
        $pemilik = User::where('role', 'pemilik')->first();

        // 3 properti tambahan
        $properti1 = Properti::create([
            'user_id' => $pemilik->id,
            'nama_properti' => 'Kos Anggrek Putih',
            'alamat' => 'Jl. Anggrek No. 22, Malang',
            'deskripsi' => 'Kos khusus putri, dekat kampus, suasana tenang dan asri.',
        ]);

        $properti2 = Properti::create([
            'user_id' => $pemilik->id,
            'nama_properti' => 'Kos Griya Sejahtera',
            'alamat' => 'Jl. Sudirman No. 45, Yogyakarta',
            'deskripsi' => 'Kos campur, lokasi strategis dekat pusat kota.',
        ]);

        $properti3 = Properti::create([
            'user_id' => $pemilik->id,
            'nama_properti' => 'Kos Bahagia Residence',
            'alamat' => 'Jl. Diponegoro No. 8, Bandung',
            'deskripsi' => 'Kos eksklusif dengan fasilitas lengkap.',
        ]);

        $properties = [$properti1, $properti2, $properti3];

        $namaKamarData = [
            ['nomor' => 'A1', 'harga' => 950000, 'fasilitas' => 'Kipas Angin, Kamar Mandi Luar'],
            ['nomor' => 'A2', 'harga' => 1250000, 'fasilitas' => 'AC, Kamar Mandi Dalam, WiFi'],
            ['nomor' => 'A3', 'harga' => 1400000, 'fasilitas' => 'AC, Kamar Mandi Dalam, WiFi, TV'],
            ['nomor' => 'B1', 'harga' => 1000000, 'fasilitas' => 'Kipas Angin, WiFi'],
            ['nomor' => 'B2', 'harga' => 1600000, 'fasilitas' => 'AC, Kamar Mandi Dalam, WiFi, Lemari'],
        ];

        $namaPenghuniData = [
            ['nama' => 'Dewi Lestari', 'email' => 'dewi.lestari@example.com', 'hp' => '081211112222'],
            ['nama' => 'Ahmad Fauzan', 'email' => 'ahmad.fauzan@example.com', 'hp' => '081233334444'],
            ['nama' => 'Putri Ayu Ningsih', 'email' => 'putri.ayu@example.com', 'hp' => '081255556666'],
            ['nama' => 'Reza Pratama', 'email' => 'reza.pratama@example.com', 'hp' => '081277778888'],
            ['nama' => 'Nabila Zahra', 'email' => 'nabila.zahra@example.com', 'hp' => '081299990000'],
            ['nama' => 'Fajar Ramadhan', 'email' => 'fajar.ramadhan@example.com', 'hp' => '081312223333'],
            ['nama' => 'Salsabila Putri', 'email' => 'salsabila.putri@example.com', 'hp' => '081344445555'],
        ];

        $komplainData = [
            ['kategori' => 'Air', 'deskripsi' => 'Air di kamar mandi tidak mengalir sejak pagi.', 'prioritas' => 'tinggi'],
            ['kategori' => 'Listrik', 'deskripsi' => 'Stop kontak di kamar mengeluarkan percikan api.', 'prioritas' => 'tinggi'],
            ['kategori' => 'Kerusakan', 'deskripsi' => 'Pintu lemari lepas dari engselnya.', 'prioritas' => 'sedang'],
            ['kategori' => 'Kebersihan', 'deskripsi' => 'Area parkir motor kotor dan becek.', 'prioritas' => 'rendah'],
            ['kategori' => 'WiFi', 'deskripsi' => 'Koneksi WiFi sangat lambat sejak 3 hari lalu.', 'prioritas' => 'sedang'],
        ];

        $penghuniIndex = 0;
        $komplainIndex = 0;

        foreach ($properties as $properti) {
            $kamarList = [];

            foreach ($namaKamarData as $k) {
                $kamar = Kamar::create([
                    'properti_id' => $properti->id,
                    'nomor_kamar' => $k['nomor'],
                    'harga_sewa' => $k['harga'],
                    'fasilitas' => $k['fasilitas'],
                    'status' => 'kosong',
                ]);
                $kamarList[] = $kamar;
            }

            // isi 3 dari 5 kamar dengan penghuni
            for ($i = 0; $i < 3; $i++) {
                if (!isset($namaPenghuniData[$penghuniIndex])) break;

                $data = $namaPenghuniData[$penghuniIndex];
                $kamar = $kamarList[$i];

                $user = User::create([
                    'name' => $data['nama'],
                    'email' => $data['email'],
                    'password' => Hash::make('password123'),
                    'role' => 'penghuni',
                ]);

                $penghuni = Penghuni::create([
                    'user_id' => $user->id,
                    'kamar_id' => $kamar->id,
                    'nama' => $data['nama'],
                    'email' => $data['email'],
                    'no_hp' => $data['hp'],
                    'tanggal_masuk' => now()->subMonths(rand(1, 6)),
                    'status' => 'aktif',
                ]);

                $kamar->update(['status' => 'terisi']);

                // buat tagihan untuk 3 bulan terakhir
                for ($bulan = 2; $bulan >= 0; $bulan--) {
                    $jatuhTempo = now()->subMonths($bulan)->startOfMonth()->addDays(24);
                    $statusTagihan = $bulan == 0 ? 'belum_lunas' : 'lunas';

                    $tagihan = Tagihan::create([
                        'penghuni_id' => $penghuni->id,
                        'jumlah' => $kamar->harga_sewa,
                        'jatuh_tempo' => $jatuhTempo,
                        'status' => $statusTagihan,
                    ]);

                    if ($statusTagihan == 'lunas') {
                        Pembayaran::create([
                            'tagihan_id' => $tagihan->id,
                            'jumlah_bayar' => $kamar->harga_sewa,
                            'tanggal_bayar' => $jatuhTempo->copy()->subDays(rand(0, 3)),
                            'status_verifikasi' => 'diterima',
                        ]);
                    }
                }

                // tambahkan komplain untuk sebagian penghuni
                if (isset($komplainData[$komplainIndex])) {
                    $c = $komplainData[$komplainIndex];
                    Komplain::create([
                        'penghuni_id' => $penghuni->id,
                        'kategori' => $c['kategori'],
                        'deskripsi' => $c['deskripsi'],
                        'prioritas' => $c['prioritas'],
                        'status' => $komplainIndex % 2 == 0 ? 'diproses' : 'selesai',
                    ]);
                    $komplainIndex++;
                }

                $penghuniIndex++;
            }
        }
    }
}