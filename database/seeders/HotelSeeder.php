<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\Currency;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Hotel::create([
            'currency_id' => Currency::where('iso', 'TRY')->first()->id,
            'name' => 'Hotel Golden Beach',
            'email' => 'info@goldenbeach.com',
            'phone' => '+90 212 123 4567',
            'star' => 5,
            'city' => 'Istanbul',
            'district' => 'Sultanahmet',
            'address' => 'Sultanahmet Meydanı, Istanbul, Turkey',
            'min_child_age' => 6,
            'max_child_age' => 12,
            'min_accomodation' => 1,
            'check_in_time' => '14:00',
            'check_out_time' => '12:00'
        ]);

        Hotel::create([
            'currency_id' => Currency::where('iso', 'EUR')->first()->id,
            'name' => 'Hotel Blue Lagoon',
            'email' => 'contact@bluelagoon.com',
            'phone' => '+90 224 987 6543',
            'star' => 4,
            'city' => 'Bursa',
            'district' => 'Mudanya',
            'address' => 'Mudanya District, Bursa, Turkey',
            'min_child_age' => 10,
            'max_child_age' => 10,
            'min_accomodation' => 2,
            'check_in_time' => '15:00',
            'check_out_time' => '11:00'
        ]);

        Hotel::create([
            'currency_id' => Currency::where('iso', 'USD')->first()->id,
            'name' => 'Hotel Sunset Resort',
            'email' => 'info@sunsetresort.com',
            'phone' => '+90 532 456 7890',
            'star' => 3,
            'city' => 'Antalya',
            'district' => 'Kemer',
            'address' => 'Kemer, Antalya, Turkey',
            'min_child_age' => 4,
            'max_child_age' => 8,
            'min_accomodation' => 1,
            'check_in_time' => '16:00',
            'check_out_time' => '10:00'
        ]);
    }
}
