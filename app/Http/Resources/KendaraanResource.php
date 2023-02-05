<?php

namespace App\Http\Resources;

use App\Models\Kendaraan;
use Illuminate\Http\Resources\Json\JsonResource;

class KendaraanResource extends JsonResource
{
    private $message;

    public function __construct(Kendaraan $kendaraan, string $message = null)
    {
        parent::__construct($kendaraan);
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
            '_id' => $this->id,
            'jenis' => $this->jenis,
            'merek' => $this->merek,
            'model' => $this->model,
            'tahun_keluaran' => $this->tahun_keluaran,
            'warna' => $this->warna,
            'stock' => $this->stock,
            'harga' => $this->harga,
        ];

        if(request()->routeIs('kendaraan.index')) return $data;
        else {
            $additionalData['mesin'] = $this->mesin;
            if($this->jenis == 'mobil')
                $additionalData += [
                    'kapasitas_penumpang' => $this->kapasitas_penumpang,
                    'tipe' => $this->tipe
                ];
            else
                $additionalData += [
                    'tipe_suspensi' => $this->tipe_suspensi,
                    'tipe_transmisi' => $this->tipe_transmisi
                ];

            $data = array_merge($data, $additionalData);

            return [
                'message' => $this->message,
                'data' => [
                    'kendaraan' => $data,
                ]
            ];
        }
    }
}
