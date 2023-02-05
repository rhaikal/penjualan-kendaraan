<?php

namespace App\Services;

use App\Models\Penjualan;
use App\Repository\KendaraanRepository;
use App\Repository\PenjualanRepository;

class PenjualanService
{
    private PenjualanRepository $penjualanRepository;
    private KendaraanRepository $kendaraanRepository;

    public function __construct(PenjualanRepository $penjualanRepository, KendaraanRepository $kendaraanRepository)
    {
        $this->penjualanRepository = $penjualanRepository;
        $this->kendaraanRepository = $kendaraanRepository;
    }

    public function getPenjualan(int $paginate)
    {
        return $this->penjualanRepository->paginate(10);
    }

    public function createPenjualan(array $data)
    {
        $kendaraan = $this->kendaraanRepository->getById($data['kendaraan']['id']);

        if($kendaraan->stock > 0){
            $processedData = [
                'status' => 'proses',
                'metode' => $data['metode'],
                'pembeli' => $data['pembeli'],
                'kendaraan' => $data['kendaraan'],
                'catatan' => $data['catatan'],
                'biaya' => [
                    'booking_fee' => $data['booking_fee'],
                ]
            ];

            $processedData['biaya']['harga_kendaraan']['subtotal'] = $kendaraan->harga;
            if($processedData['kendaraan']['otr'] == 'On The Road'){
                $biayaBbnkb = $kendaraan->harga - ((10 * $kendaraan->harga) / 100);
                $biayaPkb = $kendaraan->harga - ((2 * $kendaraan->harga) / 100);
                $biayaBiroJasa = 250000;
                $biayaStck = 25000;
                $biayaTnkb = null;
                $biayaStnk = null;
                $biayaBpkb = null;
                $biayaSwdkllj = null;
                if($kendaraan->jenis == 'mobil') {
                    $biayaStnk = 200000;
                    $biayaTnkb = 100000;
                    $biayaBpkb = 375000;
                    $biayaSwdkllj = 143000;
                } else {
                    $biayaStnk = 100000;
                    $biayaTnkb = 60000;
                    $biayaBpkb = 225000;
                    $biayaSwdkllj = 32000;
                }

                $processedData['biaya']['harga_kendaraan']['total'] = $biayaBbnkb + $biayaPkb + $biayaBiroJasa + $biayaStck + $biayaTnkb + $biayaStnk + $biayaBpkb + $biayaSwdkllj;
            } else $processedData['biaya']['harga_kendaraan']['total'] = $kendaraan->harga;

            if(isset($data['diskon'])) {
                $processedData['biaya']['harga_kendaraan'] = array_merge($processedData['biaya']['harga_kendaraan'], [
                    'diskon' => $data['diskon'],
                    'total' => $this->percentageMultiplicationAssignment($processedData['biaya']['harga_kendaraan']['total'], $data['diskon'])
                ]);
            }

            $processedData['biaya']['dp'] = [
                'presentasi' =>  $data['dp'],
                'subtotal' => $data['dp'] * $processedData['biaya']['harga_kendaraan']['total']/100
            ];

            if($data['metode'] == 'Kredit'){
                $processedData['biaya']['provisi'] = [
                        'presentase' => $data['provisi'],
                        'nominal' => $data['provisi'] * $processedData['biaya']['harga_kendaraan']['total']/100
                ];

                $processedData['biaya']['asuransi'] = array_merge($data['asuransi'], [
                    'nominal' => $data['asuransi']['persentase'] * $processedData['biaya']['harga_kendaraan']['total']/100
                ]);

                $processedData['biaya']['angsuran'] = array_merge($data['angsuran'], [
                    'per_bulan' => ($processedData['biaya']['harga_kendaraan']['total'] - $processedData['biaya']['dp']['subtotal']) / $data['angsuran']['jangka_waktu']
                ]);

                if($data['angsuran']['jenis'] == 'ADDM'){
                    $processedData['biaya']['dp'] = array_merge($processedData['biaya']['dp'], [
                        'jangka_waktu' => $processedData['biaya']['angsuran']['jangka_waktu'] - 1,
                        'total' => $processedData['biaya']['dp']['subtotal'] + $processedData['biaya']['angsuran']['per_bulan']
                    ]);
                }
            }

            if(!isset($processedData['biaya']['dp']['total'])) $processedData['biaya']['dp']['total'] = $processedData['biaya']['dp']['subtotal'];

            if(!!$data['catatan']) $processedData['catatan'] = $data['catatan'];

            $this->kendaraanRepository->update($kendaraan, ['stock' => $kendaraan->stock - 1]);

            return $this->penjualanRepository->create($processedData);
        } return null;
    }

    public function updatePenjualan(Penjualan $penjualan, array $data)
    {
        return $this->penjualanRepository->update($penjualan, $data);
    }

    public function deletePenjualan(Penjualan $penjualan)
    {
        return $this->penjualanRepository->delete($penjualan);
    }

    public function percentageMultiplicationAssignment($number, $percentage)
    {
        return $number - $number * $percentage / 100;
    }
}
