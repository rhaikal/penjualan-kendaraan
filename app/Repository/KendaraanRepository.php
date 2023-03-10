<?php

namespace App\Repository;

use App\Models\Kendaraan;

class KendaraanRepository
{
    public function getById($id)
    {
        return Kendaraan::find($id);
    }

    public function paginate($paginate)
    {
        return Kendaraan::paginate($paginate);
    }

    public function create(array $data)
    {
        return Kendaraan::create($data);
    }

    public function update(Kendaraan $kendaraan, array $data)
    {
        return $kendaraan->update($data);
    }

    public function delete(Kendaraan $kendaraan)
    {
        return $kendaraan->delete($kendaraan);
    }
}
