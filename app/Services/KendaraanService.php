<?php

namespace App\Services;

use App\Models\Kendaraan;
use App\Repository\KendaraanRepository;

class KendaraanService
{
    private KendaraanRepository $kendaraanRepository;

    public function __construct(KendaraanRepository $kendaraanRepository)
    {
        $this->kendaraanRepository = $kendaraanRepository;
    }

    public function getKendaraan(int $paginate)
    {
        return $this->kendaraanRepository->paginate($paginate);
    }

    public function createKendaraan(array $data)
    {
        return $this->kendaraanRepository->create($data);
    }

    public function updateKendaraan(Kendaraan $kendaraan, array $data)
    {
        return $this->kendaraanRepository->update($kendaraan, $data);
    }

    public function deleteKendaraan(Kendaraan $kendaraan)
    {
        return $this->kendaraanRepository->delete($kendaraan);
    }
}
