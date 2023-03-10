<?php

namespace App\Http\Resources;

use App\Models\Penjualan;
use Illuminate\Http\Resources\Json\JsonResource;

class PenjualanResource extends JsonResource
{
    private $message;

    public function __construct(Penjualan $penjualan, string $message = null)
    {
        parent::__construct($penjualan);
        $this->message = $message;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            '_id' => $this->_id,
            'status' => $this->status,
            'metode' => $this->metode,
        ];

        if(request()->routeIs('penjualan.index')){
            $data = array_merge($data, [
                'kendaraan' => [
                    'jenis' => $this->kendaraanDetail->jenis,
                    'merek' => $this->kendaraanDetail->merek,
                    'model' => $this->kendaraanDetail->model
                ],
                'nama_pembeli' => $this->pembeli['nama'],
                'biaya' => [
                    'harga_kendaraan' => $this->biaya['harga_kendaraan']['total'],
                    'dp' => $this->biaya['dp']['total'],
                ]
            ]);

            if($this->metode == 'Kredit')
                $data['biaya']['angsuran'] = [
                    'per_bulan' => $this->biaya['angsuran']['per_bulan'],
                    'jangka_waktu' => $this->biaya['angsuran']['jangka_waktu']
                ];

            return $data;
        } else
            $data = array_merge($data, [
                'kendaraan' => $this->kendaraan,
                'pembeli' => $this->pembeli,
                'biaya' => $this->biaya,
                'catatan' => $this->catatan,
            ]);

        return [
            'message' => $this->message,
            'data' => [
                'penjualan' => $data
            ]
        ];
    }
}
