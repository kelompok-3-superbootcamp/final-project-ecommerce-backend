<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Type;
use App\Models\Brand;
use Carbon\Carbon;

class CarSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $date = Carbon::now()->modify('+1 day');
    $timestamps = clone $date;

    $hybrid = Type::where('name', 'Hybrid')->first()->id;
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
      ['name' => 'Sigra', 'color' => fake()->safeColorName(), 'description' => 'Mobil transmisi bensin', 'price' => 70000000, 'transmission' => 'automatic', 'location' => fake('id-ID')->city(), 'condition' => 'baru', 'year' => 2013, 'km' => 0, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $daihatsu, 'type_id' => $bensin, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Calya', 'color' => fake()->safeColorName(), 'description' => 'Mobil transmisi hybrid', 'price' => 90000000, 'transmission' => 'manual', 'location' => fake('id-ID')->city(), 'condition' => 'bekas', 'year' => 2014, 'km' => 200000, 'stock' => 2, 'image' => 'test.com', 'brand_id' => $toyota, 'type_id' => $hybrid, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'AirEv', 'color' => fake()->safeColorName(), 'description' => 'Mobil listrik', 'price' => 110000000, 'transmission' => 'automatic', 'location' => fake('id-ID')->city(), 'condition' => 'baru', 'year' => 2015, 'km' => 0, 'stock' => 3, 'image' => 'test.com', 'brand_id' => $wuling, 'type_id' => $listrik, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Panther', 'color' => fake()->safeColorName(), 'description' => 'Mobil transmisi hybrid', 'price' => 130000000, 'transmission' => 'manual', 'location' => fake('id-ID')->city(), 'condition' => 'bekas', 'year' => 2016, 'km' => 400000, 'stock' => 4, 'image' => 'test.com', 'brand_id' => $isuzu, 'type_id' => $solar, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Picanto', 'color' => fake()->safeColorName(), 'description' => 'Mobil transmisi bensin', 'price' => 150000000, 'transmission' => 'automatic', 'location' => fake('id-ID')->city(), 'condition' => 'baru', 'year' => 2017, 'km' => 0, 'stock' => 5, 'image' => 'test.com', 'brand_id' => $kia, 'type_id' => $bensin, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Ertiga', 'color' => fake()->safeColorName(), 'description' => 'Mobil transmisi bensin', 'price' => 170000000, 'transmission' => 'automatic', 'location' => fake('id-ID')->city(), 'condition' => 'bekas', 'year' => 2018, 'km' => 150000, 'stock' => 6, 'image' => 'test.com', 'brand_id' => $suzuki, 'type_id' => $listrik, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Ioniq 5', 'color' => fake()->safeColorName(), 'description' => 'Mobil listrik', 'price' => 700000000, 'transmission' => 'automatic', 'location' => fake('id-ID')->city(), 'condition' => 'baru', 'year' => 2019, 'km' => 0, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $hyundai, 'type_id' => $listrik, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Terios', 'color' => fake()->safeColorName(), 'description' => 'Mobil transmisi bensin', 'price' => 170000000, 'transmission' => 'automatic', 'location' => fake('id-ID')->city(), 'condition' => 'bekas', 'year' => 2020, 'km' => 5000, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $daihatsu, 'type_id' => $bensin, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Rush', 'color' => fake()->safeColorName(), 'description' => 'Mobil transmisi bensin', 'price' => 180000000, 'transmission' => 'manual', 'location' => fake('id-ID')->city(), 'condition' => 'baru', 'year' => 2021, 'km' => 0, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $toyota, 'type_id' => $bensin, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Ayla', 'color' => fake()->safeColorName(), 'description' => 'Mobil transmisi bensin', 'price' => 70000000, 'transmission' => 'automatic', 'location' => fake('id-ID')->city(), 'condition' => 'bekas', 'year' => 2022, 'km' => 15000, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $suzuki, 'type_id' => $bensin, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Agya', 'color' => fake()->safeColorName(), 'description' => 'Mobil transmisi bensin', 'price' => 80000000, 'transmission' => 'manual', 'location' => fake('id-ID')->city(), 'condition' => 'baru', 'year' => 2023, 'km' => 0, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $kia, 'type_id' => $bensin, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Karimun', 'color' => fake()->safeColorName(), 'description' => 'Mobil transmisi bensin', 'price' => 60000000, 'transmission' => 'automatic', 'location' => fake('id-ID')->city(), 'condition' => 'bekas', 'year' => 2024, 'km' => 25000, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $wuling, 'type_id' => $listrik, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Alvez', 'color' => fake()->safeColorName(), 'description' => 'Mobil transmisi bensin', 'price' => 270000000, 'transmission' => 'manual', 'location' => fake('id-ID')->city(), 'condition' => 'baru', 'year' => 2023, 'km' => 0, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $hyundai, 'type_id' => $listrik, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Cortez', 'color' => fake()->safeColorName(), 'description' => 'Mobil transmisi bensin', 'price' => 160000000, 'transmission' => 'manual', 'location' => fake('id-ID')->city(), 'condition' => 'bekas', 'year' => 2024, 'km' => 35000, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $isuzu, 'type_id' => $bensin, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'APV', 'color' => fake()->safeColorName(), 'description' => 'Mobil transmisi bensin', 'price' => 80000000, 'transmission' => 'automatic', 'location' => fake('id-ID')->city(), 'condition' => 'baru', 'year' => 2022, 'km' => 0, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $suzuki, 'type_id' => $bensin, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Carnival', 'color' => fake()->safeColorName(), 'description' => 'Mobil transmisi bensin', 'price' => 370000000, 'transmission' => 'automatic', 'location' => fake('id-ID')->city(), 'condition' => 'bekas', 'year' => 2021, 'km' => 45000, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $daihatsu, 'type_id' => $solar, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Carens', 'color' => fake()->safeColorName(), 'description' => 'Mobil transmisi bensin', 'price' => 470000000, 'transmission' => 'manual', 'location' => fake('id-ID')->city(), 'condition' => 'baru', 'year' => 2020, 'km' => 0, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $toyota, 'type_id' => $bensin, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Santa Fe', 'color' => fake()->safeColorName(), 'description' => 'Mobil transmisi bensin', 'price' => 570000000, 'transmission' => 'automatic', 'location' => fake('id-ID')->city(), 'condition' => 'bekas', 'year' => 2019, 'km' => 50000, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $kia, 'type_id' => $solar, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Creta', 'color' => fake()->safeColorName(), 'description' => 'Mobil transmisi bensin', 'price' => 670000000, 'transmission' => 'manual', 'location' => fake('id-ID')->city(), 'condition' => 'baru', 'year' => 2018, 'km' => 0, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $wuling, 'type_id' => $hybrid, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Ioniq 6', 'color' => fake()->safeColorName(), 'description' => 'Mobil transmisi bensin', 'price' => 770000000, 'transmission' => 'automatic', 'location' => fake('id-ID')->city(), 'condition' => 'bekas', 'year' => 2017, 'km' => 60000, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $isuzu, 'type_id' => $hybrid, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'StarGazer', 'color' => fake()->safeColorName(), 'description' => 'Mobil transmisi bensin', 'price' => 870000000, 'transmission' => 'manual', 'location' => fake('id-ID')->city(), 'condition' => 'baru', 'year' => 2016, 'km' => 0, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $hyundai, 'type_id' => $hybrid, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Ignis', 'color' => fake()->safeColorName(), 'description' => 'Mobil transmisi bensin', 'price' => 970000000, 'transmission' => 'automatic', 'location' => fake('id-ID')->city(), 'condition' => 'bekas', 'year' => 2015, 'km' => 70000, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $daihatsu, 'type_id' => $bensin, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Avanza', 'color' => fake()->safeColorName(), 'description' => 'Mobil transmisi bensin', 'price' => 110000000, 'transmission' => 'manual', 'location' => fake('id-ID')->city(), 'condition' => 'baru', 'year' => 2014, 'km' => 0, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $toyota, 'type_id' => $solar, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Xenia', 'color' => fake()->safeColorName(), 'description' => 'Mobil transmisi bensin', 'price' => 130000000, 'transmission' => 'automatic', 'location' => fake('id-ID')->city(), 'condition' => 'bekas', 'year' => 2013, 'km' => 80000, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $kia, 'type_id' => $solar, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'EV9', 'color' => fake()->safeColorName(), 'description' => 'Mobil transmisi bensin', 'price' => 140000000, 'transmission' => 'manual', 'location' => fake('id-ID')->city(), 'condition' => 'baru', 'year' => 2012, 'km' => 0, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $kia, 'type_id' => $listrik, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Rocky', 'color' => fake()->safeColorName(), 'description' => 'Mobil transmisi bensin', 'price' => 190000000, 'transmission' => 'automatic', 'location' => fake('id-ID')->city(), 'condition' => 'bekas', 'year' => 2011, 'km' => 90000, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $hyundai, 'type_id' => $bensin, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Raize', 'color' => fake()->safeColorName(), 'description' => 'Mobil transmisi bensin', 'price' => 21000000, 'transmission' => 'manual', 'location' => fake('id-ID')->city(), 'condition' => 'baru', 'year' => 2010, 'km' => 0, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $hyundai, 'type_id' => $bensin, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Sonet', 'color' => fake()->safeColorName(), 'description' => 'Mobil transmisi bensin', 'price' => 220000000, 'transmission' => 'automatic', 'location' => fake('id-ID')->city(), 'condition' => 'bekas', 'year' => 2009, 'km' => 100000, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $wuling, 'type_id' => $listrik, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'EV6', 'color' => fake()->safeColorName(), 'description' => 'Mobil transmisi bensin', 'price' => 230000000, 'transmission' => 'manual', 'location' => fake('id-ID')->city(), 'condition' => 'baru', 'year' => 2010, 'km' => 0, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $wuling, 'type_id' => $bensin, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Baleno', 'color' => fake()->safeColorName(), 'description' => 'Mobil transmisi bensin', 'price' => 240000000, 'transmission' => 'automatic', 'location' => fake('id-ID')->city(), 'condition' => 'bekas', 'year' => 2011, 'km' => 110000, 'stock' => 1, 'image' => 'test.com', 'brand_id' => $kia, 'type_id' => $bensin, 'user_id' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
    ];

    DB::table('cars')->insert($cars);
  }
}
