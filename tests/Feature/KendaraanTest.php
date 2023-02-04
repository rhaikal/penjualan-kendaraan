<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class KendaraanTest extends TestCase
{
    use WithFaker;

    protected $headers = ['Accept' => 'application/json'];

    /**
     * A create car feature test.
     *
     * @return void
     */
    public function test_can_make_new_vehicle()
    {
        $data = [
            'jenis' => $this->faker->randomElement(['mobil', 'motor']),
            'merek' => $this->faker->company(),
            'model' => $this->faker->word(),
            'tahun_keluaran' => $this->faker->year(),
            'warna' => $this->faker->colorName(),
            'stock' => rand(1, 100),
        ];

        if($data['jenis'] == 'mobil') {
            $additionalData = [
                'kapasitas_penumpang' => rand(1, 8),
                'tipe' => $this->faker->randomElement(['SUV', 'MPV', 'Crossover', 'Hatchback', 'Sedan', 'Sport Sedan', 'Convertible', 'Station Wagon', 'Off Road', 'Pickup Truck', 'Double Cabin', 'Elektrik', 'Hybrid', 'LCGC']),
            ];

            if($additionalData['tipe'] == 'Elektrik') $additionalData['mesin'] = $this->faker->randomElement(['BEV', 'PHEV', 'HEV', 'FCEV']);
            else $additionalData['mesin'] = $this->faker->randomElement(['ECE', 'ICE']);

            $data = array_merge($data, $additionalData);
        } else {
            $additionalData = [
                'mesin' => $this->faker->randomElement(['DOHC', 'SOHC', 'OHV']),
                'tipe_suspensi' => $this->faker->randomElement(['Pararel Fork', 'Plunger Rear Suspension', 'Telescopic Fork', 'Swing Arm Rear Suspension']),
                'tipe_transmisi' => $this->faker->randomElement(['Manual', 'Semi Otomatis', 'Otomatis'])
            ];

            $data = array_merge($data, $additionalData);
        }

        $user = User::latest()->first();
        $response = $this->actingAs($user)->withHeaders($this->headers)->postJson(route('kendaraan.store'), $data);
        $response->assertStatus(201);
        $response->assertJson(['message' => 'Berhasil menambahkan kendaraan baru']);
    }
}
