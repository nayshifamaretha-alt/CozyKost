<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penghuni extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kamar_id',
        'nama',
        'email',
        'no_hp',
        'tanggal_masuk',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class);
    }

    public function komplain()
    {
        return $this->hasMany(Komplain::class);
    }
}