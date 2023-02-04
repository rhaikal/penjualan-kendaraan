<?php

namespace App\Services;

use App\Repository\KendaraanRepository;

class KendaraanService
{
    private KendaraanRepository $kendaraanRepository;

    public function __construct(KendaraanRepository $kendaraanRepository)
    {
        $this->kendaraanRepository = $kendaraanRepository;
    }

    public function createKendaraan(array $data)
    {
        return $this->kendaraanRepository->create($data);
    }
}
