<?php

namespace Database\Seeders;

use App\Models\Appoinment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Appoinment::factory(2)->create();
    }
}
