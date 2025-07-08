<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Konsultasi extends Model
{
    protected $fillable = [
        'user_id',
        'dokter_id',
        'tanggal',
        'waktu',
        'status',
        'catatan',
        'hasil_konsultasi',
    ];

    // Relasi ke user yang mengajukan konsultasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke dokter (jika ada)
    public function dokter()
    {
        return $this->belongsTo(\App\Models\Dokter::class, 'dokter_id');
    }
}
