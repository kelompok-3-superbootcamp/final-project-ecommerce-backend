<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Type;
use App\Models\Brand;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $matic = Type::where('name', 'Matic')->first()->id;
        $manual = Type::where('name', 'Manual')->first()->id;
        $listrik = Type::where('name', 'listrik')->first()->id;
        $solar = Type::where('name', 'solar')->first()->id;
        $bensin = Type::where('name', 'bensin')->first()->id;

        $toyota = Brand::where('name', 'toyota')->first()->id;
        $daihatsu = Brand::where('name', 'daihatsu')->first()->id;
        $wuling = Brand::where('name', 'wuling')->first()->id;
        $isuzu = Brand::where('name', 'isuzu')->first()->id;
        $kia = Brand::where('name', 'kia')->first()->id;
        $suzuki = Brand::where('name', 'suzuki')->first()->id;
        $hyundai = Brand::where('name', 'hyundai')->first()->id;

        $cars = [
            ['name' => 'Sigra', 'description' => 'Mobil transmisi matic', 'price' => 70000000, 'transmission' => 'matic', 'condition' => 'baru', 'year' => 2013, 'km' => 0, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $daihatsu, 'type_id' => $matic, 'user_id' => 1],
            ['name' => 'Calya', 'description' => 'Mobil transmisi manual', 'price' => 90000000, 'transmission' => 'manual', 'condition' => 'bekas', 'year' => 2014, 'km' => 200000, 'stock' => 2, 'image' => 'test.com', 'brand_id' => $toyota, 'type_id' => $manual, 'user_id' => 1],
            ['name' => 'AirEv', 'description' => 'Mobil listrik', 'price' => 110000000, 'transmission' => 'matic', 'condition' => 'baru', 'year' => 2015, 'km' => 0, 'stock' => 3, 'image' => 'test.com', 'brand_id' => $wuling, 'type_id' => $listrik, 'user_id' => 1],
            ['name' => 'Panther', 'description' => 'Mobil transmisi manual', 'price' => 130000000, 'transmission' => 'manual', 'condition' => 'bekas', 'year' => 2016, 'km' => 400000, 'stock' => 4, 'image' => 'test.com', 'brand_id' => $isuzu, 'type_id' => $solar, 'user_id' => 1],
            ['name' => 'Picanto', 'description' => 'Mobil transmisi matic', 'price' => 150000000, 'transmission' => 'matic', 'condition' => 'baru', 'year' => 2017, 'km' => 0, 'stock' => 5, 'image' => 'test.com', 'brand_id' => $kia, 'type_id' => $matic, 'user_id' => 1],
            ['name' => 'Ertiga', 'description' => 'Mobil transmisi matic', 'price' => 170000000, 'transmission' => 'matic', 'condition' => 'bekas', 'year' => 2018, 'km' => 150000, 'stock' => 6, 'image' => 'test.com', 'brand_id' => $suzuki, 'type_id' => $listrik, 'user_id' => 1],
            ['name' => 'Ioniq 5', 'description' => 'Mobil listrik', 'price' => 700000000, 'transmission' => 'matic', 'condition' => 'baru', 'year' => 2019, 'km' => 0, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $hyundai, 'type_id' => $listrik, 'user_id' => 1],
            ['name' => 'Terios', 'description' => 'Mobil transmisi matic', 'price' => 170000000, 'transmission' => 'matic', 'condition' => 'bekas', 'year' => 2020, 'km' => 5000, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $daihatsu, 'type_id' => $bensin, 'user_id' => 1],
            ['name' => 'Rush', 'description' => 'Mobil transmisi matic', 'price' => 180000000, 'transmission' => 'manual', 'condition' => 'baru', 'year' => 2021, 'km' => 0, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $toyota, 'type_id' => $matic, 'user_id' => 1],
            ['name' => 'Ayla', 'description' => 'Mobil transmisi matic', 'price' => 70000000, 'transmission' => 'matic', 'condition' => 'bekas', 'year' => 2022, 'km' => 15000, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $suzuki, 'type_id' => $bensin, 'user_id' => 1],
            ['name' => 'Agya', 'description' => 'Mobil transmisi matic', 'price' => 80000000, 'transmission' => 'manual', 'condition' => 'baru', 'year' => 2023, 'km' => 0, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $kia, 'type_id' => $matic, 'user_id' => 1],
            ['name' => 'Karimun', 'description' => 'Mobil transmisi matic', 'price' => 60000000, 'transmission' => 'matic', 'condition' => 'bekas', 'year' => 2024, 'km' => 25000, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $wuling, 'type_id' => $listrik, 'user_id' => 1],
            ['name' => 'Alvez', 'description' => 'Mobil transmisi matic', 'price' => 270000000, 'transmission' => 'manual', 'condition' => 'baru', 'year' => 2023, 'km' => 0, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $hyundai, 'type_id' => $listrik, 'user_id' => 1],
            ['name' => 'Cortez', 'description' => 'Mobil transmisi matic', 'price' => 160000000, 'transmission' => 'manual', 'condition' => 'bekas', 'year' => 2024, 'km' => 35000, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $isuzu, 'type_id' => $bensin, 'user_id' => 1],
            ['name' => 'APV', 'description' => 'Mobil transmisi matic', 'price' => 80000000, 'transmission' => 'matic', 'condition' => 'baru', 'year' => 2022, 'km' => 0, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $suzuki, 'type_id' => $bensin, 'user_id' => 1],
            ['name' => 'Carnival', 'description' => 'Mobil transmisi matic', 'price' => 370000000, 'transmission' => 'matic', 'condition' => 'bekas', 'year' => 2021, 'km' => 45000, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $daihatsu, 'type_id' => $solar, 'user_id' => 1],
            ['name' => 'Carens', 'description' => 'Mobil transmisi matic', 'price' => 470000000, 'transmission' => 'manual', 'condition' => 'baru', 'year' => 2020, 'km' => 0, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $toyota, 'type_id' => $bensin, 'user_id' => 1],
            ['name' => 'Santa Fe', 'description' => 'Mobil transmisi matic', 'price' => 570000000, 'transmission' => 'matic', 'condition' => 'bekas', 'year' => 2019, 'km' => 50000, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $kia, 'type_id' => $solar, 'user_id' => 1],
            ['name' => 'Creta', 'description' => 'Mobil transmisi matic', 'price' => 670000000, 'transmission' => 'manual', 'condition' => 'baru', 'year' => 2018, 'km' => 0, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $wuling, 'type_id' => $manual, 'user_id' => 1],
            ['name' => 'Ioniq 6', 'description' => 'Mobil transmisi matic', 'price' => 770000000, 'transmission' => 'matic', 'condition' => 'bekas', 'year' => 2017, 'km' => 60000, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $isuzu, 'type_id' => $manual, 'user_id' => 1],
            ['name' => 'StarGazer', 'description' => 'Mobil transmisi matic', 'price' => 870000000, 'transmission' => 'manual', 'condition' => 'baru', 'year' => 2016, 'km' => 0, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $hyundai, 'type_id' => $manual, 'user_id' => 1],
            ['name' => 'Ignis', 'description' => 'Mobil transmisi matic', 'price' => 970000000, 'transmission' => 'matic', 'condition' => 'bekas', 'year' => 2015, 'km' => 70000, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $daihatsu, 'type_id' => $matic, 'user_id' => 1],
            ['name' => 'Avanza', 'description' => 'Mobil transmisi matic', 'price' => 110000000, 'transmission' => 'manual', 'condition' => 'baru', 'year' => 2014, 'km' => 0, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $toyota, 'type_id' => $solar, 'user_id' => 1],
            ['name' => 'Xenia', 'description' => 'Mobil transmisi matic', 'price' => 130000000, 'transmission' => 'matic', 'condition' => 'bekas', 'year' => 2013, 'km' => 80000, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $kia, 'type_id' => $solar, 'user_id' => 1],
            ['name' => 'EV9', 'description' => 'Mobil transmisi matic', 'price' => 140000000, 'transmission' => 'manual', 'condition' => 'baru', 'year' => 2012, 'km' => 0, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $kia, 'type_id' => $listrik, 'user_id' => 1],
            ['name' => 'Rocky', 'description' => 'Mobil transmisi matic', 'price' => 190000000, 'transmission' => 'matic', 'condition' => 'bekas', 'year' => 2011, 'km' => 90000, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $hyundai, 'type_id' => $matic, 'user_id' => 1],
            ['name' => 'Raize', 'description' => 'Mobil transmisi matic', 'price' => 21000000, 'transmission' => 'manual', 'condition' => 'baru', 'year' => 2010, 'km' => 0, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $hyundai, 'type_id' => $bensin, 'user_id' => 1],
            ['name' => 'Sonet', 'description' => 'Mobil transmisi matic', 'price' => 220000000, 'transmission' => 'matic', 'condition' => 'bekas', 'year' => 2009, 'km' => 100000, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $wuling, 'type_id' => $listrik, 'user_id' => 1],
            ['name' => 'EV6', 'description' => 'Mobil transmisi matic', 'price' => 230000000, 'transmission' => 'manual', 'condition' => 'baru', 'year' => 2010, 'km' => 0, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $wuling, 'type_id' => $bensin, 'user_id' => 1],
            ['name' => 'Baleno', 'description' => 'Mobil transmisi matic', 'price' => 240000000, 'transmission' => 'matic', 'condition' => 'bekas', 'year' => 2011, 'km' => 110000, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $kia, 'type_id' => $matic, 'user_id' => 1],
        ];

        DB::table('cars')->insert($cars);
    }
}
