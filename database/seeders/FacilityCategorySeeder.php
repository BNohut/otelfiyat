<?php

namespace Database\Seeders;

use App\Models\FacilityCategory;
use Illuminate\Database\Seeder;

class FacilityCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $facilityCategories = [
            [
                'title' => 'Outdoor',
                'description' => 'Facilities that are available outside the hotel or room. Examples include swimming pools, beaches, gardens, and sports courts.'
            ],
            [
                'title' => 'Indoor',
                'description' => 'Facilities located inside the hotel, such as gyms, spas, restaurants, and indoor pools.'
            ],
            [
                'title' => 'Room',
                'description' => 'Facilities available directly in the hotel rooms. This may include amenities like air conditioning, minibar, TV, and room service.'
            ]
        ];

        foreach ($facilityCategories as $category) {
            $currentCategory = FacilityCategory::where('title', $category['title'])->first();
            if (!$currentCategory) {
                FacilityCategory::create($category);
            } else {
                $currentCategory->update($category);
            }
        }
    }
}
