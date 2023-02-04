<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Services\KendaraanService;
use App\Http\Resources\KendaraanResource;
use App\Http\Requests\StoreKendaraanRequest;
use App\Http\Requests\UpdateKendaraanRequest;

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

    public function show(Kendaraan $kendaraan)
    {
        return new KendaraanResource($kendaraan, 'Berhasil mendapatkan data kendaraan');
    }

    public function update(UpdateKendaraanRequest $request, Kendaraan $kendaraan)
    {
        $validatedData = $request->validated();

        $this->kendaraanService->updateKendaraan($kendaraan, $validatedData);

        return new KendaraanResource($kendaraan, 'Berhasil mengubah data kendaraan');
    }

    public function destroy(Kendaraan $kendaraan)
    {
        $this->kendaraanService->deleteKendaraan($kendaraan);

        return response()->json(['message' => 'Berhasil menghapus kendaraan']);
    }
}
