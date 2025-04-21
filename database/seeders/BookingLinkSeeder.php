<?php

namespace Database\Seeders;

use App\Models\BookingLink;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BookingLink::factory()
            ->count(3)
            ->create();
    }
}
