<?php

namespace App\Repository;

use App\Models\Penjualan;

class PenjualanRepository
{
    public function create(array $data)
    {
        return Penjualan::create($data);
    }
}
