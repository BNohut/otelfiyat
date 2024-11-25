<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Artisan::call('key:generate');
        Artisan::call('storage:link');

        $this->call(
            [
                CurrencySeeder::class,
                RoomOfferingSeeder::class,
                ConceptSeeder::class,
                FacilityCategorySeeder::class,
                FacilitySeeder::class,
                PaymentMethodSeeder::class,
                HotelSeeder::class,
                HotelFacilitySeeder::class,
                HotelRoomSeeder::class,
            ]
        );
    }
}
