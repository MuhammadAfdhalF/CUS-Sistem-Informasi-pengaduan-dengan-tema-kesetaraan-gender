<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pelaporan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nim',
        'nohp',
        'jenis',
        'deskripsi',
        'bukti',
    ];
}
