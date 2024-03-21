<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $date = Carbon::now()->modify('+1 day');
    $timestamps = clone $date;

    $types = [
      ['name' => 'Hybrid', 'description' => 'Mobil transmisi manual', 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Bensin', 'description' => 'Mobil berbahan bakar bensin', 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Solar', 'description' => 'Mobil berbahan bakar solar', 'created_at' => $timestamps, 'updated_at' => $timestamps],
      ['name' => 'Listrik', 'description' => 'Mobil listrik', 'created_at' => $timestamps, 'updated_at' => $timestamps],
    ];

    DB::table('types')->insert($types);
  }
}
