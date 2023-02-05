<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePenjualanRequest;
use App\Http\Resources\PenjualanResource;
use App\Services\PenjualanService;
use Illuminate\Http\Request;

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

    public function store(StorePenjualanRequest $request)
    {
        $validatedData = $request->validated();

        $penjualan = $this->penjualanService->createPenjualan($validatedData);

        if(!!$penjualan){
            return new PenjualanResource($penjualan, 'Berhasil menambahkan penjualan');
        } return response()->json(['message' => 'Stock kendaraan habis']);
    }
}
