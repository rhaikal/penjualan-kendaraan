<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KendaraanService;
use App\Http\Requests\StoreKendaraanRequest;
use App\Http\Resources\KendaraanResource;

class KendaraanController extends Controller
{
    private KendaraanService $kendaraanService;

    public function __construct(KendaraanService $kendaraanService)
    {
        $this->kendaraanService = $kendaraanService;
    }

    public function store(StoreKendaraanRequest $request)
    {
        $validatedData = $request->validated();

        $kendaraan = $this->kendaraanService->createKendaraan($validatedData);

        return new KendaraanResource($kendaraan, 'Berhasil menambahkan kendaraan baru');
    }
}
