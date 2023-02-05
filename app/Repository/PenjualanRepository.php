<?php

namespace App\Repository;

use App\Models\Penjualan;

class PenjualanRepository
{
    public function paginate(int $paginate)
    {
        return Penjualan::with('kendaraanDetail')->paginate($paginate);
    }

    public function create(array $data)
    {
        return Penjualan::create($data);
    }

    public function update(Penjualan $penjualan, array $data)
    {
        return $penjualan->update($data);
    }
}
