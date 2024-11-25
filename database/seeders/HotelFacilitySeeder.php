<?php

namespace Database\Seeders;

use App\Models\Facility;
use App\Models\FacilityCategory;
use App\Models\Hotel;
use Illuminate\Database\Seeder;

class HotelFacilitySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // Indoor ve Outdoor kategorilerinden tesisler alınıyor
    $indoorOutdoorCategories = FacilityCategory::whereIn('title', ['indoor', 'outdoor'])->pluck('id');

    // Bu kategorilere ait olan tesisler alınıyor
    $facilities = Facility::whereIn('facility_category_id', $indoorOutdoorCategories)->get();

    // Tüm oteller alınıyor
    $hotels = Hotel::all();

    foreach ($hotels as $hotel) {
      // Her otele rastgele 3 tesis atanıyor
      $selectedFacilities = $facilities->random(3);

      foreach ($selectedFacilities as $facility) {
        $hotel->facilities()->syncWithoutDetaching([$facility->id]);
      }
    }
  }
}
