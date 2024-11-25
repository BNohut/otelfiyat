<?php

namespace Database\Seeders;

use App\Models\HotelRoom;
use App\Models\Facility;
use App\Models\Hotel;
use App\Models\Concept;
use App\Models\RoomOffering;
use App\Models\Currency;
use Illuminate\Database\Seeder;

class HotelRoomSeeder extends Seeder
{
  public function run()
  {
    // Örnek oteller
    $hotels = Hotel::all(); // Tüm otelleri alıyoruz

    // Her otel için 4 oda oluşturuluyor
    foreach ($hotels as $hotel) {
      for ($i = 1; $i <= 4; $i++) {
        // Rastgele Concept, RoomOffering ve Currency seçiliyor
        $concept = Concept::inRandomOrder()->first(); // Rastgele Concept seçimi
        $roomOffering = RoomOffering::inRandomOrder()->first(); // Rastgele RoomOffering seçimi
        $currency = Currency::inRandomOrder()->first(); // Rastgele Currency seçimi

        // Her oda için gerekli bilgileri oluşturuyoruz
        $hotelRoom = HotelRoom::create([
          'hotel_id' => $hotel->id,
          'concept_id' => $concept->id,
          'room_offering_id' => $roomOffering->id,
          'currency_id' => $currency->id,
          'number' => $hotel->id . '-' . $i,  // Oda numarasını hotel_id ve oda indexi ile oluşturuyoruz
          'bed_count' => rand(1, 4),  // Rastgele yatak sayısı
          'adult_unit_price' => rand(50, 150),  // Rastgele yetişkin ücreti
          'child_unit_price' => rand(25, 75),  // Rastgele çocuk ücreti
          'extra_concept_price_adult' => rand(10, 30),  // Rastgele ek konsept fiyatı (yetişkin)
          'extra_concept_price_child' => rand(5, 15),  // Rastgele ek konsept fiyatı (çocuk)
          'check_out_date' => null,  // Oda çıkış tarihi boş
        ]);

        // İlgili odalar için indoor ve outdoor tesisler atanıyor
        $facilities = Facility::whereIn('facility_category_id', [1, 2])->get(); // indoor ve outdoor tesisleri alıyoruz
        $hotelRoom->facilities()->sync($facilities->pluck('id'));
      }
    }
  }
}
