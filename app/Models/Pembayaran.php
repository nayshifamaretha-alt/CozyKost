<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'tagihan_id',
        'jumlah_bayar',
        'bukti_transfer',
        'tanggal_bayar',
        'status_verifikasi',
    ];

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }
}