<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $date = Carbon::now()->modify('+1 day');
    $timestamps = clone $date;

    $brands = [
      ['name' => 'Daihatsu', 'logo_url' => 'https://via.placeholder.com/200x200', 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Toyota', 'logo_url' => 'https://via.placeholder.com/200x200', 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Wuling', 'logo_url' => 'https://via.placeholder.com/200x200', 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Isuzu', 'logo_url' => 'https://via.placeholder.com/200x200', 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Kia', 'logo_url' => 'https://via.placeholder.com/200x200', 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Suzuki', 'logo_url' => 'https://via.placeholder.com/200x200', 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Hyundai', 'logo_url' => 'https://via.placeholder.com/200x200', 'created_at' => $timestamps, 'updated_at' => $timestamps],
    ];

    DB::table('brands')->insert($brands);
  }
}
