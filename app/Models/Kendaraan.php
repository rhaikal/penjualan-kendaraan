<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   protected $fillable = [
        'jenis',
        'merek',
        'model',
        'tahun_keluaran',
        'warna',
        'harga',
        'stock',
        'mesin',
        // motor
        'tipe_suspensi',
        'tipe_transmisi',
        // mobil
        'kapasitas_penumpang',
        'tipe'
   ];
}
