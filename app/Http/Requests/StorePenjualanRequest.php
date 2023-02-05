<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StorePenjualanRequest extends FormRequest
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
            'metode' => ['required', Rule::in(['Cash', 'Kredit'])],
            'booking_fee' => ['required', 'integer'],
            'dp' => ['required', 'integer', 'min:1', 'max:99'],
            'kendaraan' => ['required', 'array'],
            'kendaraan.id' => ['required', 'exists:kendaraans,_id'],
            'kendaraan.atas_nama' => ['required', 'string'],
            'kendaraan.otr' => ['required', Rule::in(['Off The Road', 'On The Road'])],
            'pembeli' => ['required', 'array'],
            'pembeli.nama' => ['required', 'string'],
            'pembeli.no_ktp' => ['required', 'string', 'size:16'],
            'pembeli.no_hp' => ['required', 'string'],
            'pembeli.email' => ['required', 'email'],
            'pembeli.alamat' => ['required', 'array'],
            'pembeli.alamat.*.jalan' => ['required', 'string'],
            'pembeli.alamat.*.kelurahan' => ['required', 'string'],
            'pembeli.alamat.*.kecamatan' => ['required', 'string'],
            'pembeli.alamat.*.kota' => ['required', 'string'],
            'pembeli.alamat.*.provinsi' => ['required', 'string'],
            'pembeli.alamat.*.kode_pos' => ['required', 'digits_between:4,6'],
            'pembeli.berkas.ktp' => ['required', 'boolean'],
            'catatan' => ['sometimes', 'required', 'string'],
            'diskon' => ['sometimes', 'required', 'integer', 'max:99', 'min:1'],
        ];

        if($this->input('metode') == 'Kredit') {
            $rules['provisi'] = ['required', 'decimal:2'];
            $rules['asuransi'] = ['required', 'array'];
            $rules['asuransi.jenis'] = ['required', Rule::in(['all risk', 'total loss only'])];
            $rules['asuransi.persentase'] = ['required', 'decimal:2'];
            $rules['angsuran'] = ['required', 'array'];
            $rules['angsuran.jenis'] = ['required', Rule::in(['ADDM', 'ADDB'])];
            $rules['angsuran.jangka_waktu'] = ['required', 'integer', 'max:72']; // in month
            $rules['pembeli.berkas.kk'] = ['required', 'boolean'];
            $rules['pembeli.berkas.npwp'] = ['required', 'boolean'];
            $rules['pembeli.berkas.bukti_kontrak_rumah'] = ['sometimes', 'required', 'boolean'];
            $rules['pembeli.berkas.bukti_kepemilikan_rumah'] = ['sometimes', 'required', 'boolean'];
            $rules['pembeli.berkas.rekening_koran'] = ['required', 'boolean'];
        }

        return $rules;
    }
}
