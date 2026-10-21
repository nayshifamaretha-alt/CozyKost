<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $fillable = [
        'penghuni_id',
        'jumlah',
        'jatuh_tempo',
        'status',
    ];

    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }
}