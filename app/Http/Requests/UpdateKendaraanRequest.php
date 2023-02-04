<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateKendaraanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'merek' => 'sometimes|required|string',
            'model' => 'sometimes|required|string',
            'tahun_keluaran' => 'sometimes|required|numeric',
            'warna' => 'sometimes|required|string',
            'stock' => 'sometimes|required|integer'
        ];

        if($this->kendaraan->jenis == 'mobil'){
            $rules['kapasitas_penumpang'] = ['sometimes', 'required', 'integer'];
            $rules['tipe'] = ['sometimes', 'required', Rule::in(['SUV', 'MPV', 'Crossover', 'Hatchback', 'Sedan', 'Sport Sedan', 'Convertible', 'Station Wagon', 'Off Road', 'Pickup Truck', 'Double Cabin', 'Elektrik', 'Hybrid', 'LCGC'])];
            if(($this->input('tipe') ?? $this->kendaraan->tipe) == 'Elektrik') $rules['mesin'] = ['sometimes', 'required', Rule::in(['BEV', 'PHEV', 'HEV', 'FCEV'])];
            else $rules['mesin'] = ['sometimes', 'required', Rule::in(['ICE', 'ECE'])];
        } else {
            $rules['mesin'] = ['sometimes', 'required', Rule::in(['DOHC', 'SOHC', 'OHV'])];
            $rules['tipe_suspensi'] = ['sometimes', 'required', Rule::in(['Pararel Fork', 'Plunger Rear Suspension', 'Telescopic Fork', 'Swing Arm Rear Suspension'])];
            $rules['tipe_transmisi'] = ['sometimes', 'required', Rule::in(['Manual', 'Semi Otomatis', 'Otomatis'])];
        }

        return $rules;
    }
}
