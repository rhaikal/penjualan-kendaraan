<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Laporan\PenjualanExport;
use App\Exports\Laporan\PenjualanMobilExport;
use App\Exports\Laporan\PenjualanMotorExport;

class LaporanController extends Controller
{
    public function all()
    {
        return Excel::download(new PenjualanExport, 'penjualan.xlsx');
    }

    public function cars()
    {
        return Excel::download(new PenjualanMobilExport, 'penjualan-mobil.xlsx');
    }

    public function motorcycles()
    {
        return Excel::download(new PenjualanMotorExport, 'penjualan-motor.xlsx');
    }
}
