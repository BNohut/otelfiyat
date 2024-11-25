<?php

namespace Database\Seeders;

use App\Models\RoomOffering;
use Illuminate\Database\Seeder;

class RoomOfferingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roomOfferings = [
            [
                'title' => 'Single',
                'description' => 'A single room with a single bed for one person.',
                'color_hex_code' => '#db8585'
            ],
            [
                'title' => 'Double',
                'description' => 'A room with a double bed for two persons.',
                'color_hex_code' => '#4d896a'
            ],
            [
                'title' => 'Twin',
                'description' => 'A room with two single beds, usually for two persons.',
                'color_hex_code' => '#9c6bff'
            ],
            [
                'title' => 'Classic',
                'description' => 'A classic style room with comfortable furnishings.',
                'color_hex_code' => '#f5b842'
            ],
            [
                'title' => 'Deluxe',
                'description' => 'A luxury room offering extra comfort and amenities.',
                'color_hex_code' => '#4a90e2'
            ],
            [
                'title' => 'Superior',
                'description' => 'A superior room with more space and upgraded amenities.',
                'color_hex_code' => '#ff9e3d'
            ],
            [
                'title' => 'Junior',
                'description' => 'A smaller suite with a comfortable lounge area.',
                'color_hex_code' => '#ff4e50'
            ],
            [
                'title' => 'Executive',
                'description' => 'A high-end room with premium services for business guests.',
                'color_hex_code' => '#b92d65'
            ],
            [
                'title' => 'Family',
                'description' => 'A room designed to accommodate families, usually with multiple beds.',
                'color_hex_code' => '#83c9a0'
            ],
            [
                'title' => 'Honeymoon',
                'description' => 'A romantic room for newlyweds, featuring luxury touches.',
                'color_hex_code' => '#f1b1e3'
            ],
            [
                'title' => 'Penthouse',
                'description' => 'An exclusive top-floor suite with exceptional views.',
                'color_hex_code' => '#d4af37'
            ],
            [
                'title' => 'Villa',
                'description' => 'A spacious, private residence offering luxury and privacy.',
                'color_hex_code' => '#75aef5'
            ],
            [
                'title' => 'Bungalow',
                'description' => 'A standalone house, usually close to the beach or garden.',
                'color_hex_code' => '#8fbc8f'
            ],
            [
                'title' => 'King',
                'description' => 'A room with a large king-sized bed, ideal for two adults.',
                'color_hex_code' => '#9b59b6'
            ],
            [
                'title' => 'Queen',
                'description' => 'A room with a queen-sized bed, slightly smaller than the king.',
                'color_hex_code' => '#c39bd3'
            ],
        ];

        foreach ($roomOfferings as $offering) {
            $currentOffering = RoomOffering::where('title', $offering['title'])->first();
            if (!$currentOffering) {
                RoomOffering::create($offering);
            } else {
                $currentOffering->update($offering);
            }
        }
    }
}
