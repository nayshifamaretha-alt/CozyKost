<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;

    protected $fillable = [
        'properti_id',
        'nomor_kamar',
        'harga_sewa',
        'fasilitas',
        'status',
    ];

    public function properti()
    {
        return $this->belongsTo(Properti::class);
    }

    public function penghuni()
    {
        return $this->hasMany(Penghuni::class);
    }
}