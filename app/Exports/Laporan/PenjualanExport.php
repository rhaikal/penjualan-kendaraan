<?php

namespace App\Exports\Laporan;

use App\Models\Kendaraan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PenjualanExport implements FromView
{
    public function view(): View
    {
        $kendaraan = Kendaraan::with('penjualans')->orderBy('jenis', 'desc')->get();

        return view('laporan/penjualan', [
            'kendaraans' => $kendaraan
        ]);
    }
}
