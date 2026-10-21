<?php

namespace Database\Seeders;

use App\Models\Komplain;
use App\Models\Pembayaran;
use App\Models\Penghuni;
use App\Models\Tagihan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DataContohSeeder extends Seeder
{
    /** Simpan data, hanya kolom yang memang ada di tabel */
    private function simpan(string $model, array $data)
    {
        $obj = new $model;
        $kolom = Schema::getColumnListing($obj->getTable());
        $obj->forceFill(array_intersect_key($data, array_flip($kolom)));
        $obj->save();

        return $obj;
    }

    public function run(): void
    {
        $statusDiterima = Pembayaran::whereIn('status_verifikasi', ['diterima', 'terverifikasi'])
            ->value('status_verifikasi') ?? 'diterima';
        $statusBelum = Tagihan::where('status', '!=', 'lunas')->value('status') ?? 'belum';

        $penghunis = Penghuni::with('kamar')->where('status', 'aktif')->get();

        // Tagihan 6 bulan terakhir, plus pembayaran untuk yang lunas
        foreach ($penghunis as $i => $p) {
            if (!$p->kamar) {
                continue;
            }

            foreach ([5, 4, 3, 2, 1, 0] as $mundur) {
                $awal = now()->startOfMonth()->subMonths($mundur);

                $sudahAda = Tagihan::where('penghuni_id', $p->id)
                    ->whereYear('created_at', $awal->year)
                    ->whereMonth('created_at', $awal->month)
                    ->exists();
                if ($sudahAda) {
                    continue;
                }

                // Bulan lalu semua lunas. Bulan ini: rina belum bayar, sisanya selang-seling.
                $lunas = $mundur > 0 || (strtolower($p->nama) !== 'rina' && $i % 2 === 0);
                $dibuat = $awal->copy()->addDay()->setTime(8, 0);

                $tagihan = $this->simpan(Tagihan::class, [
                    'penghuni_id' => $p->id,
                    'jumlah' => $p->kamar->harga_sewa,
                    'status' => $lunas ? 'lunas' : $statusBelum,
                    'jatuh_tempo' => $awal->copy()->day(10)->toDateString(),
                    'created_at' => $dibuat,
                    'updated_at' => $dibuat,
                ]);

                if ($lunas) {
                    $tglBayar = $awal->copy()->day(3 + ($i % 6))->setTime(10, 0);

                    $this->simpan(Pembayaran::class, [
                        'tagihan_id' => $tagihan->id,
                        'jumlah_bayar' => $tagihan->jumlah,
                        'tanggal_bayar' => $tglBayar->toDateString(),
                        'status_verifikasi' => $statusDiterima,
                        'created_at' => $tglBayar,
                        'updated_at' => $tglBayar,
                    ]);
                }
            }
        }

        // Komplain contoh (rina duluan)
        $contoh = [
            ['Fasilitas', 'AC di kamar kurang dingin, mohon dicek', 'sedang', 'diproses'],
            ['Kebersihan', 'Kamar mandi luar sering kotor', 'rendah', 'selesai'],
            ['Listrik', 'Lampu koridor lantai 2 mati', 'tinggi', 'diproses'],
            ['Air', 'Air kamar mandi mengalir kecil di pagi hari', 'sedang', 'selesai'],
        ];

        $urut = $penghunis
            ->sortBy(fn ($p) => strtolower($p->nama) === 'rina' ? 0 : 1)
            ->values()
            ->take(count($contoh));

        foreach ($urut as $k => $p) {
            if (Komplain::where('penghuni_id', $p->id)->exists()) {
                continue;
            }

            [$kategori, $deskripsi, $prioritas, $status] = $contoh[$k];
            $waktu = now()->subDays(($k + 1) * 2);

            $this->simpan(Komplain::class, [
                'penghuni_id' => $p->id,
                'kategori' => $kategori,
                'deskripsi' => $deskripsi,
                'prioritas' => $prioritas,
                'status' => $status,
                'created_at' => $waktu,
                'updated_at' => $waktu,
            ]);
        }
    }
}