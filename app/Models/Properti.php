<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Properti extends Model
{
    use HasFactory;

    protected $table = 'properties';

    protected $fillable = [
        'user_id',
        'nama_properti',
        'alamat',
        'deskripsi',
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kamar()
    {
        return $this->hasMany(Kamar::class);
    }
        public function admin()
    {
        return $this->belongsToMany(User::class, 'admin_properti', 'properti_id', 'user_id');
    }
}