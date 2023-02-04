<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreKendaraanRequest extends FormRequest
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
            'jenis' => 'required|in:mobil,motor',
            'merek' => 'required|string',
            'model' => 'required|string',
            'tahun_keluaran' => 'required|numeric',
            'warna' => 'required|string',
            'harga' => 'required|integer',
            'stock' => 'required|integer'
        ];

        if($this->input('jenis') == 'mobil'){
            $rules['kapasitas_penumpang'] = ['required', 'integer'];
            $rules['tipe'] = ['required', Rule::in(['SUV', 'MPV', 'Crossover', 'Hatchback', 'Sedan', 'Sport Sedan', 'Convertible', 'Station Wagon', 'Off Road', 'Pickup Truck', 'Double Cabin', 'Elektrik', 'Hybrid', 'LCGC'])];
            if($this->input('tipe') == 'Elektrik') $rules['mesin'] = ['required', Rule::in(['BEV', 'PHEV', 'HEV', 'FCEV'])];
            else $rules['mesin'] = ['required', Rule::in(['ICE', 'ECE'])];
        } else {
            $rules['mesin'] = ['required', Rule::in(['DOHC', 'SOHC', 'OHV'])];
            $rules['tipe_suspensi'] = ['required', Rule::in(['Pararel Fork', 'Plunger Rear Suspension', 'Telescopic Fork', 'Swing Arm Rear Suspension'])];
            $rules['tipe_transmisi'] = ['required', Rule::in(['Manual', 'Semi Otomatis', 'Otomatis'])];
        }

        return $rules;
    }
}
