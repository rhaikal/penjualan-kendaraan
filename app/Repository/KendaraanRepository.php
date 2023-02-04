<?php

namespace App\Repository;

use App\Models\Kendaraan;

class KendaraanRepository
{
    public function create(array $data)
    {
        return Kendaraan::create($data);
    }
}
