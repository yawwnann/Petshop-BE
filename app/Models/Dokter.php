<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $fillable = [
        'nama',
        'email',
        'spesialisasi',
        'no_str',
        'telepon',
        'alamat',
    ];
}
