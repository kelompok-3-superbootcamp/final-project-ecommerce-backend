<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'Matic', 'description' => 'Mobil transmisi matic'],
            ['name' => 'Manual', 'description' => 'Mobil transmisi manual'],
            ['name' => 'Bensin', 'description' => 'Mobil berbahan bakar bensin'],
            ['name' => 'Solar', 'description' => 'Mobil berbahan bakar solar'],
            ['name' => 'Listrik', 'description' => 'Mobil listrik'],
        ];

        DB::table('types')->insert($types);
    }
}
