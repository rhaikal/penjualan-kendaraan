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
        return [
            'message' => $this->message,
            'data' => [
                'status' => $this->status,
                'metode' => $this->metode,
                'kendaraan' => $this->kendaraan,
                'pembeli' => $this->pembeli,
                'biaya' => $this->biaya,
                'catatan' => $this->catatan,
            ]
        ];
    }
}
