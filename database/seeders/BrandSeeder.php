<?php

namespace Database\Seeders;

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
        $brands = [
            ['name' => 'Daihatsu', 'logo_url' => 'test.com'],
            ['name' => 'Toyota', 'logo_url' => 'test.com'],
            ['name' => 'Wuling', 'logo_url' => 'test.com'],
            ['name' => 'Isuzu', 'logo_url' => 'test.com'],
            ['name' => 'Kia', 'logo_url' => 'test.com'],
            ['name' => 'Suzuki', 'logo_url' => 'test.com'],
            ['name' => 'Hyundai', 'logo_url' => 'test.com'],
        ];

        DB::table('brands')->insert($brands);
    }
}
