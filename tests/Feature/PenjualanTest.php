<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kendaraan;
use App\Models\Penjualan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PenjualanTest extends TestCase
{
    use WithFaker;

    protected $headers = ['Accept' => 'application/json'];

    /**
     * A make new sale feature test.
     *
     * @return void
     */
    public function test_can_make_new_sale()
    {
        $kendaraan = Kendaraan::first();

        $data = [
            'metode' => $this->faker->randomElement(['Cash', 'Kredit']),
            'booking_fee' => rand(100000, 1000000),
            'dp' => rand(25, 30),
            'kendaraan' => [
                'id' => $kendaraan->_id,
                'atas_nama' => $this->faker->name(),
                'otr' => $this->faker->randomElement(['Off The Road', 'On The Road'])
            ],
            'pembeli' => [
                'nama' => $this->faker->name(),
                'no_ktp' => $this->faker->numerify('################'),
                'no_hp' => $this->faker->phoneNumber(),
                'email' => $this->faker->email(),
                'alamat' => [[
                    'jalan' => $this->faker->streetAddress(),
                    'kelurahan' => 'Kelurahan',
                    'kecamatan' => 'Kecamatan',
                    'kota' => $this->faker->city(),
                    'provinsi' => $this->faker->state(),
                    'kode_pos' => $this->faker->numerify('######'),
                ]],
                'berkas' => ['ktp'  => true ]
            ],
            'catatan' => $this->faker->sentence(),
            'diskon' => rand(2, 50)
        ];

        if($data['metode'] == 'Kredit'){
            $data = array_merge($data, [
                'provisi' => $this->faker->randomFloat(2, 0, 1),
                'asuransi' => [
                    'jenis' => $this->faker->randomElement(['all risk', 'total loss only']),
                    'persentase' => $this->faker->randomFloat(2, 0, 4),
                ],
                'angsuran' => [
                    'jenis' => $this->faker->randomElement(['ADDM', 'ADDB']),
                    'jangka_waktu' => rand(1, 72),
                ],
            ]);

            $data['pembeli']['berkas']['kk'] = true;
            $data['pembeli']['berkas']['npwp'] = true;
            $data['pembeli']['berkas']['bukti_kepemilikan_rumah'] = true;
            $data['pembeli']['berkas']['rekening_koran'] = true;
        }

        $user = User::latest()->first();
        $response = $this->withHeaders($this->headers)->actingAs($user)->postJson(route('penjualan.store'), $data);
        $response->assertStatus(201);
        $response->assertJson(['message' => 'Berhasil menambahkan penjualan']);
    }

    /**
     * A see sales data feature.
     *
     * @return void
     */
    public function test_can_see_sales_data()
    {
        $user = User::latest()->first();
        $response = $this->withHeaders($this->headers)->actingAs($user)->getJson(route('penjualan.index'));
        $response->assertStatus(200);
    }

    /**
     * A see specific sale data feature.
     *
     * @return void
     */
    public function test_can_see_specific_sale_data()
    {
        $penjualan = Penjualan::latest()->first();
        $user = User::latest()->first();
        $response = $this->withHeaders($this->headers)->actingAs($user)->getJson(route('penjualan.show', $penjualan));
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Berhasil mendapatkan data penjualan']);
    }
}
