<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Penjualan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   protected $fillable = [
        'status',
        'metode',
        'kendaraan',
        'pembeli',
        'biaya',
        'catatan',
    ];

    public function kendaraanDetail()
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan.id');
    }
}
