<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Services\PenjualanService;
use App\Http\Resources\PenjualanResource;
use App\Http\Requests\StorePenjualanRequest;
use App\Http\Requests\UpdatePenjualanRequest;

class PenjualanController extends Controller
{
    private PenjualanService $penjualanService;

    public function __construct(PenjualanService $penjualanService)
    {
        $this->penjualanService = $penjualanService;
    }

    public function index()
    {
        $penjualan = $this->penjualanService->getPenjualan(10);

        return PenjualanResource::collection($penjualan);
    }

    public function show(Penjualan $penjualan)
    {
        return new PenjualanResource($penjualan, 'Berhasil mendapatkan data penjualan');
    }

    public function store(StorePenjualanRequest $request)
    {
        $validatedData = $request->validated();

        $penjualan = $this->penjualanService->createPenjualan($validatedData);

        if(!!$penjualan){
            return new PenjualanResource($penjualan, 'Berhasil menambahkan penjualan');
        } return response()->json(['message' => 'Stock kendaraan habis']);
    }

    public function update(UpdatePenjualanRequest $request, Penjualan $penjualan)
    {
        if($penjualan->status == 'proses'){
            $validatedData = $request->validated();

            $this->penjualanService->updatePenjualan($penjualan, $validatedData);

            return new PenjualanResource($penjualan, 'Berhasil mengubah penjualan');
        }else return response()->json(['message' => 'penjualan telah selesai']);
    }
}
