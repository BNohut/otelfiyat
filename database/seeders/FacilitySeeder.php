<?php

namespace Database\Seeders;

use App\Models\Facility;
use App\Models\FacilityCategory;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $categories = FacilityCategory::all();
    // dump($categories);

    foreach ($categories as $category) {
      $facilities = match ($category->title) {
        'Indoor' => [
          ['title' => 'Swimming Pool', 'icon' => 'fa-solid fa-swimming-pool'],
          ['title' => 'Sauna', 'icon' => 'fa-solid fa-spa'],
          ['title' => 'Gym', 'icon' => 'fa-solid fa-dumbbell'],
        ],
        'Outdoor' => [
          ['title' => 'Garden', 'icon' => 'fa-solid fa-tree'],
          ['title' => 'Tennis Court', 'icon' => 'fa-solid fa-tennis-ball'],
          ['title' => 'Barbecue Area', 'icon' => 'fa-solid fa-fire'],
        ],
        'Room' => [
          ['title' => 'Mini Bar', 'icon' => 'fa-solid fa-wine-glass'],
          ['title' => 'Air Conditioning', 'icon' => 'fa-solid fa-wind'],
          ['title' => 'Flat Screen TV', 'icon' => 'fa-solid fa-tv'],
        ],
        default => [],
      };
      foreach ($facilities as $facility) {
        $data = [
          'facility_category_id' => $category->id,
          'title' => $facility['title'],
          'icon' => $facility['icon'],
        ];
        Facility::updateOrCreate($data);
      }
    }
  }
}
