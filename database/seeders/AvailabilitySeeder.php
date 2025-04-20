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
        // Create 10 random availability records
        Avaiability::factory(3)->create();
    }
}
