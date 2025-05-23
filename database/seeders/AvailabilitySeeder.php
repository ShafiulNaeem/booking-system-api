<?php

namespace Database\Seeders;

use App\Models\Avaiability;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Avaiability::factory(5)->create();
    }
}
