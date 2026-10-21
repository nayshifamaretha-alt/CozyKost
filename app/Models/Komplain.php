<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komplain extends Model
{
    use HasFactory;

    protected $fillable = [
        'penghuni_id',
        'kategori',
        'deskripsi',
        'prioritas',
        'status',
    ];

    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class);
    }
}