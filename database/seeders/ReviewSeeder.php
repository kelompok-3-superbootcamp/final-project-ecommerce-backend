<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $date = Carbon::now()->modify('+1 day');
    $timestamps = clone $date;

    $reviews = [
      [
        'car_id' => 1,
        'user_id' => 1,
        'comment' => 'Keren kk',
        'star_count' => 5,
        'created_at' => $timestamps,
        'updated_at' => $timestamps,
      ],
      [
        'car_id' => 1,
        'user_id' => 2,
        'comment' => 'Irit bensin',
        'star_count' => 3,
        'created_at' => $timestamps,
        'updated_at' => $timestamps,
      ],
      [
        'car_id' => 1,
        'user_id' => 3,
        'comment' => 'Mobil nya kuat',
        'star_count' => 4,
        'created_at' => $timestamps,
        'updated_at' => $timestamps,
      ]
    ];

    DB::table('reviews')->insert($reviews);
  }
}
