<?php

namespace Database\Seeders;

use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\Properti;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class RapikanDataSeeder extends Seeder
{
    /** Isi dan simpan model, hanya kolom yang memang ada di tabel */
    private function simpan(Model $obj, array $data): Model
    {
        $kolom = Schema::getColumnListing($obj->getTable());
        $obj->forceFill(array_intersect_key($data, array_flip($kolom)));
        $obj->save();

        return $obj;
    }

    /** Nama properti baru dari alamat, misal "jl. Bukit Kismadani 3" jadi "Kos Bukit Kismadani" */
    private function namaDariAlamat(?string $alamat, string $cadangan): string
    {
        $nama = trim(preg_replace('/^\s*(jl\.?|jln\.?|jalan)\s*/i', '', (string) $alamat));
        $nama = trim(preg_replace('/[\s,]*\d+.*$/', '', $nama));

        if ($nama === '') {
            return $cadangan . ' 2';
        }

        $kandidat = 'Kos ' . Str::title($nama);

        return Properti::where('nama_properti', $kandidat)->exists() ? $cadangan . ' 2' : $kandidat;
    }

    public function run(): void
    {
        $info = fn (string $pesan) => $this->command?->info($pesan);

        // Password penghuni baru disamakan dengan akun rina (kalau tidak ada: password123)
        $hashPassword = Penghuni::where('nama', 'rina')->first()?->user?->password
            ?? Hash::make('password123');

        // 1. Kamar berstatus terisi tapi belum ada penghuni aktif -> buatkan penghuni
        $daftarNama = ['Rizky Pratama', 'Nadia Safitri', 'Budi Santoso', 'Maya Anggraini', 'Dimas Prakoso', 'Sinta Maharani'];
        $urut = 0;

        $kamarTerisi = Kamar::with(['penghuni', 'properti'])->where('status', 'terisi')->get();

        foreach ($kamarTerisi as $kamar) {
            if ($kamar->penghuni->where('status', 'aktif')->isNotEmpty()) {
                continue;
            }

            $nama = $daftarNama[$urut % count($daftarNama)];
            $email = Str::slug($nama, '.') . '@example.com';

            $user = $this->simpan(User::firstWhere('email', $email) ?? new User(), [
                'name' => $nama,
                'email' => $email,
                'password' => $hashPassword,
                'role' => 'penghuni',
                'email_verified_at' => now(),
            ]);

            $this->simpan(new Penghuni(), [
                'user_id' => $user->id,
                'kamar_id' => $kamar->id,
                'nama' => $nama,
                'email' => $email,
                'no_hp' => '08125557' . (100 + $urut),
                'tanggal_masuk' => now()->subMonths(4)->toDateString(),
                'status' => 'aktif',
            ]);

            $info("Penghuni {$nama} ditambahkan ke kamar {$kamar->nomor_kamar} ({$kamar->properti->nama_properti})");
            $urut++;
        }

        // 2. Properti kembar yang belum punya kamar -> ganti nama dan beri kamar
        $kembar = Properti::all()
            ->groupBy(fn ($p) => strtolower(trim($p->nama_properti)))
            ->filter(fn ($grup) => $grup->count() > 1);

        foreach ($kembar as $grup) {
            $terurut = $grup->sortByDesc(fn ($p) => $p->kamar()->count())->values();

            foreach ($terurut->slice(1) as $p) {
                if ($p->kamar()->count() > 0) {
                    continue;
                }

                $lama = $p->nama_properti;
                $p->nama_properti = $this->namaDariAlamat($p->alamat, $lama);
                $p->save();
                $info("Properti kembar '{$lama}' diganti nama jadi '{$p->nama_properti}'");

                foreach (['C1', 'C2', 'C3'] as $nomor) {
                    $this->simpan(new Kamar(), [
                        'properti_id' => $p->id,
                        'nomor_kamar' => $nomor,
                        'harga_sewa' => 1100000,
                        'fasilitas' => 'Kasur, lemari, kamar mandi dalam, Wi-Fi',
                        'status' => 'kosong',
                    ]);
                }

                $info("3 kamar (C1, C2, C3) ditambahkan ke {$p->nama_properti}");
            }
        }

        // 3. Sinkronkan status semua kamar dengan penghuni aktifnya
        Kamar::with('penghuni')->get()->each(function ($kamar) use ($info) {
            $seharusnya = $kamar->penghuni->where('status', 'aktif')->isNotEmpty() ? 'terisi' : 'kosong';

            if ($kamar->status !== $seharusnya) {
                $kamar->status = $seharusnya;
                $kamar->save();
                $info("Status kamar {$kamar->nomor_kamar} disesuaikan jadi {$seharusnya}");
            }
        });

        // 4. Isi tagihan, pembayaran, dan komplain untuk penghuni baru
        $this->call(DataContohSeeder::class);

        $info('Selesai. Data demo sudah dirapikan.');
    }
}