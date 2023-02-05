<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Project

REST API untuk penjualan kendaraan

## Requirement

PHP 8
Mongodb 4.2

## Installation

Clone the project

```bash
  git clone https://github.com/rhaikal/penjualan-kendaraan
```

Navigate to the application directory

```bash
    cd penjualan-kendaraan
```

Install composer dependencies

```bash
  composer Install
```

Copy env.example

> Setting your database

```bash
  cp .env-example .env
```

Generate application key

```bash
  php artisan key:generate
```

Migrate and seed the database

```bash
  php artisan migrate --seed
```

Run the project

```bash
  php artisan serve
```
## API Reference

Setiap request memerlukan token(authorization) yang didapat dari login/register
| Header                    | Type     | Description                |
| :------------------------ | :------- | :------------------------- |
| `Authorization`           | `Bearer` | **Required**               |

#### User
###### Register

```
  POST /api/auth/register
```

```
    [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => [Password::required(), 'confirmed'],
    ]
```

###### Login

```
  POST /api/auth/login
```


```
    [
        'email' => 'required|email',
        'password' => 'required|string',
        'remember' => 'boolean'
    ]
```

###### Get Data User

```
  GET /api/auth/data
```

###### Refresh token

```
  POST /api/auth/refresh
```

###### Logout

```
  POST /api/auth/logout
```

#### Kendaraan
###### Create new kendaraan

```
  POST /api/kendaraan
```

```
    [
        'jenis' => 'required|in:mobil,motor',
        'merek' => 'required|string',
        'model' => 'required|string',
        'tahun_keluaran' => 'required|numeric',
        'warna' => 'required|string',
        'harga' => 'required|integer',
        'stock' => 'required|integer'
    ]
```

- tambahan input

jika jenis kendaraan = mobil
```
    [
        'kapasitas_penumpang' => ['required', 'integer'],
        'tipe' => ['required', Rule::in(['SUV', 'MPV', 'Crossover', 'Hatchback', 'Sedan', 'Sport Sedan', 'Convertible', 'Station Wagon', 'Off Road', 'Pickup Truck', 'Double Cabin', 'Elektrik', 'Hybrid', 'LCGC'])],
        'mesin' =>  tipe == 'Elektrik' ? ['required', Rule::in(['BEV', 'PHEV', 'HEV', 'FCEV'])] :
                                         ['required', Rule::in(['ICE', 'ECE'])],
    ]
```

jika jenis kendaraan = motor
```
    [
        'mesin' => ['required', Rule::in(['DOHC', 'SOHC', 'OHV'])],
        'tipe_suspensi => ['required', Rule::in(['Pararel Fork', 'Plunger Rear Suspension',     'Telescopic Fork', 'Swing Arm Rear Suspension'])],
        'tipe_transmisi => ['required', Rule::in(['Manual', 'Semi Otomatis', 'Otomatis]
    ]
```

###### Update Kendaraan

```
  PATCH /api/kendaraan/{id}
```

```
    [
        'merek' => 'sometimes|required|string',
        'model' => 'sometimes|required|string',
        'tahun_keluaran' => 'sometimes|required|numeric',
        'warna' => 'sometimes|required|string',
        'harga' => 'sometimes|required|integer',
        'stock' => 'sometimes|required|integer'
    ]
```

- tambahan input

jika jenis kendaraan = mobil
```
    [
        'kapasitas_penumpang' => ['sometimes', 'required', 'integer'],
        'tipe' => ['sometimes', 'required', Rule::in(['SUV', 'MPV', 'Crossover', 'Hatchback', 'Sedan', 'Sport Sedan', 'Convertible', 'Station Wagon', 'Off Road', 'Pickup Truck', 'Double Cabin', 'Elektrik', 'Hybrid', 'LCGC'])],
        'mesin' =>  tipe == 'Elektrik' ? ['sometimes', 'required', Rule::in(['BEV', 'PHEV', 'HEV', 'FCEV'])] :
                                         ['sometimes', 'required', Rule::in(['ICE', 'ECE'])],
    ]
```

jika jenis kendaraan = motor
```
    [
        'mesin' => ['sometimes', 'required', Rule::in(['DOHC', 'SOHC', 'OHV'])],
        'tipe_suspensi => ['sometimes', 'required', Rule::in(['Pararel Fork', 'Plunger Rear Suspension',     'Telescopic Fork', 'Swing Arm Rear Suspension'])],
        'tipe_transmisi => ['sometimes', 'required', Rule::in(['Manual', 'Semi Otomatis', 'Otomatis]
    ]
```

###### Get Data Kendaraan

```
  GET /api/kendaraan
```

###### Get Specific Data Kendaraan

```
  GET /api/kendaraan/{id}
```

###### Remove Kendaraan

```
  DELETE /api/kendaraan/{id}
```

#### Penjualan
###### Create Penjualan

```
  POST /api/penjualan
```

```
    [
        'metode' => ['required', Rule::in(['Cash', 'Kredit'])],
        'booking_fee' => ['required', 'integer'],
        'dp' => ['required', 'integer', 'min:1', 'max:99'],
        'kendaraan.id' => ['required', 'exists:kendaraans,_id'],
        'kendaraan.atas_nama' => ['required', 'string'],
        'kendaraan.otr' => ['required', Rule::in(['Off The Road', 'On The Road'])],
        'pembeli' => ['required', 'array'],
        'pembeli.nama' => ['required', 'string'],
        'pembeli.no_ktp' => ['required', 'string', 'size:16'],
        'pembeli.no_hp' => ['required', 'string'],
        'pembeli.email' => ['required', 'email'],
        'pembeli.alamat' => ['required', 'array'], // can have many addresses
        'pembeli.alamat.*.jalan' => ['required', 'string'],
        'pembeli.alamat.*.kelurahan' => ['required', 'string'],
        'pembeli.alamat.*.kecamatan' => ['required', 'string'],
        'pembeli.alamat.*.kota' => ['required', 'string'],
        'pembeli.alamat.*.provinsi' => ['required', 'string'],
        'pembeli.alamat.*.kode_pos' => ['required', 'digits_between:4,6'],
        'pembeli.berkas.ktp' => ['required', 'boolean'],
        'catatan' => ['sometimes', 'required', 'string'],
        'diskon' => ['sometimes', 'required', 'integer', 'max:99', 'min:1'],
    ]
```

- tambahan input

jika metode penjualan = Kredit
```
    [
        'provisi' => ['required', 'decimal:2'],
        'asuransi.jenis' => ['required', Rule::in(['all risk', 'total loss only'])],
        'asuransi.persentase' => ['required', 'decimal:2'],
        'angsuran.jenis' => ['required', Rule::in(['ADDM', 'ADDB'])],
        'angsuran.jangka_waktu' => ['required', 'integer', 'max:72'], // in month
        'pembeli.berkas.kk' => ['required', 'boolean'],
        'pembeli.berkas.npwp' => ['required', 'boolean'],
        'pembeli.berkas.bukti_kontrak_rumah' => ['sometimes', 'required', 'boolean'],
        'pembeli.berkas.bukti_kepemilikan_rumah' => ['sometimes', 'required', 'boolean'],
        'pembeli.berkas.rekening_koran' => ['required', 'boolean'],
    ]
```

###### Update Penjualan

```
  PATCH /api/penjualan/{id}
```

```
    [
        'status' => 'required|in:selesai',
    ]
```

###### Get All Data Penjualan

```
  GET /api/penjualan
```

###### Get Specific Data Penjualan

```
  GET /api/penjualan
```

###### Delete Penjualan

```
  DELETE /api/penjualan/{id}
```

#### Laporan
###### get All Laporan

```
  GET /api/laporan/penjualan
```

###### Get Laporan Mobil

```
  GET /api/penjualan-mobil
```

###### Get Laporan Motor

```
  GET /api/penjualan-mobil
```
