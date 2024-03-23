<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    User::factory(10)->create();

    User::create([
      'name' => 'Test User',
      'email' => 'test@example.com',
      'phone_number' => fake('id-ID')->e164PhoneNumber(),
      'password' => bcrypt('password')
    ]);

    User::create([
      'name' => 'Admin Sanbercar',
      'email' => 'admin@sanbercar.shop',
      'phone_number' => fake('id-ID')->e164PhoneNumber(),
      'password' => bcrypt('password'),
      'role' => 'admin'
    ]);

    $this->call([
      BrandSeeder::class,
      TypeSeeder::class,
      CarSeeder::class,
      ReviewSeeder::class
    ]);
  }
}
