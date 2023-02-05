<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Kendaraan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        if(User::count() == 0)
            User::create([
                'name' => 'Ricko Haikal',
                'email' => 'ricko@inosoft.com',
                'password' => bcrypt('ricko123'),
            ]);

        $banyakMobil = 5;
        for($i = 0; $i < $banyakMobil; $i++){
            $dataMobil = [
                'jenis' => 'mobil',
                'merek' => fake()->company(),
                'model' => fake()->word(),
                'tahun_keluaran' => fake()->year(),
                'warna' => fake()->colorName(),
                'harga' => fake()->randomNumber(9, true), //min 100 million
                'stock' => rand(1, 100),
                'kapasitas_penumpang' => rand(1, 8),
                'tipe' => fake()->randomElement(['SUV', 'MPV', 'Crossover', 'Hatchback', 'Sedan', 'Sport Sedan', 'Convertible', 'Station Wagon', 'Off Road', 'Pickup Truck', 'Double Cabin', 'Elektrik', 'Hybrid', 'LCGC']),
            ];
            $dataMobil['mesin'] =  $dataMobil['tipe'] == 'Elektrik' ? fake()->randomElement(['BEV', 'PHEV', 'HEV', 'FCEV']) : fake()->randomElement(['ECE', 'ICE']);
            Kendaraan::create($dataMobil);
        }

        $banyakMotor = 5;
        for($i = 0; $i < $banyakMotor; $i++){
            $dataMotor = [
                'jenis' => 'motor',
                'merek' => fake()->company(),
                'model' => fake()->word(),
                'tahun_keluaran' => fake()->year(),
                'warna' => fake()->colorName(),
                'harga' => fake()->randomNumber(9, true), //min 100 million
                'stock' => rand(1, 100),
                'mesin' => fake()->randomElement(['DOHC', 'SOHC', 'OHV']),
                'tipe_suspensi' => fake()->randomElement(['Pararel Fork', 'Plunger Rear Suspension', 'Telescopic Fork', 'Swing Arm Rear Suspension']),
                'tipe_transmisi' => fake()->randomElement(['Manual', 'Semi Otomatis', 'Otomatis'])
            ];
            Kendaraan::create($dataMotor);
        }
    }
}
