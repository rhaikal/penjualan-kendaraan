<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kendaraan;
use Illuminate\Foundation\Testing\WithFaker;

class KendaraanTest extends TestCase
{
    use WithFaker;

    protected $headers = ['Accept' => 'application/json'];

    /**
     * A create vehicle feature test.
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

    /**
     * A show vehicle feature test.
     *
     * @return void
     */
    public function test_can_show_vehicle()
    {
        $kendaraan = Kendaraan::latest()->first();

        $user = User::latest()->first();
        $response = $this->actingAs($user)->withHeaders($this->headers)->getJson(route('kendaraan.show', $kendaraan));
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Berhasil mendapatkan data kendaraan']);

    }

    /**
     * A update vehicle feature test.
     *
     * @return void
     */
    public function test_can_update_vehicle()
    {
        $kendaraan = Kendaraan::latest()->first();

        $data = [];

        // case adding new stock
        if(rand(0, 1))
            $data = array_merge($data, ['stock' => $kendaraan->stock + rand(1, 25)]);

        // case typo
        if(rand(0, 1))
            $data = array_merge($data, [
                'merek' => $this->faker->company(),
                'model' => $this->faker->word(),
                'tahun_keluaran' => $this->faker->year(),
                'warna' => $this->faker->colorName(),
            ]);

        // case wrong engine
        if(rand(0, 1)) {
            if($kendaraan->jenis == 'mobil') {
                if($kendaraan->tipe == 'Elektrik') $additionalData['mesin'] = $this->faker->randomElement(['BEV', 'PHEV', 'HEV', 'FCEV']);
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
        }

        if(!empty($data)) {
            $user = User::latest()->first();
            $response = $this->actingAs($user)->withHeaders($this->headers)->patchJson(route('kendaraan.update', $kendaraan), $data);
            $response->assertStatus(200);
            $response->assertJson(['message' => 'Berhasil mengubah data kendaraan']);
        } else $this->test_can_update_vehicle();
    }
}
