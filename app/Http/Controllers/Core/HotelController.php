<?php

namespace App\Http\Controllers\Core;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HotelController extends Controller
{
  public function getRooms(Request $request)
  {
    try {
      $params = [];
      // Temel SQL sorgusunu başlatıyoruz
      $sql = 'SELECT * FROM `hotel_rooms` WHERE 1=1';  // Başlangıç koşulu, her zaman doğru olur

      // Koşul bazında sorguya eklemeler yapıyoruz
      if ($request->filled('hotel_id')) {
        $sql .= ' AND `hotel_id` = :hotel_id';
        $params['hotel_id'] = $request->hotel_id;
      }

      if ($request->filled('guest_count')) {
        $sql .= ' AND `bed_count` >= :guest_count';
        $params['guest_count'] = $request->guest_count;
      }

      // Room Offering ID'yi ekliyoruz, varsa (Birden fazla ID de olabilir)
      if ($request->filled('room_offering_ids') && is_array($request->room_offering_ids) && count($request->room_offering_ids) > 0) {
        // room_offering_id bir dizi olabilir, dolayısıyla IN operatörünü kullanıyoruz
        $sql .= ' AND `room_offering_id` IN (:room_offering_id)';
        $params['room_offering_id'] = implode(',', $request->room_offering_ids);  // Dizi değerlerini virgülle ayırıyoruz
      }

      if ($request->filled('room_facility_ids') && is_array($request->room_facility_ids) && count($request->room_facility_ids) > 0) {
        $sql .= ' AND EXISTS (
                    SELECT 1
                    FROM `hotel_rooms_facilities` hrf
                    WHERE hrf.`hotel_room_id` = hotel_rooms.`id`
                    AND hrf.`facility_id` IN (:room_facility_ids)
                )';

        // Dizi değerlerini virgülle ayırarak parametreyi hazırlıyoruz
        $params['room_facility_ids'] = implode(',', $request->room_facility_ids);
      }

      if ($request->filled('hotel_facility_ids') && is_array($request->hotel_facility_ids) && count($request->hotel_facility_ids) > 0) {
        // hotel_facility_ids bir dizi olabilir, dolayısıyla IN operatörünü kullanıyoruz
        $sql .= ' AND EXISTS (
                    SELECT 1
                    FROM `hotel_facilities` hf
                    WHERE hf.`hotel_id` = hotel_rooms.`hotel_id`
                    AND hf.`facility_id` IN (:hotel_facility_ids)
                )';
        $params['hotel_facility_ids'] = implode(',', $request->hotel_facility_ids);  // Dizi değerlerini virgülle ayırıyoruz
      }

      if ($request->filled('check_in_date') && $request->filled('check_out_date')) {

        // Tarihleri doğru formatta dönüştürüyoruz
        $checkInDate = Carbon::parse($request->check_in_date)->format('Y-m-d H:i:s');
        $checkOutDate = Carbon::parse($request->check_out_date)->format('Y-m-d H:i:s');

        $sql .= ' AND NOT EXISTS (
                SELECT *
                FROM `reservations`
                WHERE `hotel_rooms`.`id` = `reservations`.`hotel_room_id`
                AND (
                        `check_in_date` BETWEEN :check_in_1 AND :check_out_1
                        OR `check_out_date` BETWEEN :check_in_2 AND :check_out_2
                        OR (
                            `check_in_date` <= :check_in_3
                            AND `check_out_date` >= :check_out_3
                        )
                    )
                )';

        $params['check_in_1'] = $checkInDate;
        $params['check_out_1'] = $checkOutDate;
        $params['check_in_2'] = $checkInDate;
        $params['check_out_2'] = $checkOutDate;
        $params['check_in_3'] = $checkInDate;
        $params['check_out_3'] = $checkOutDate;
      }
      // SQL sorgusunu çalıştırıyoruz
      $rooms = DB::select($sql, $params);

      // Hotel ID bazında gruplama işlemi yapıyoruz
      $groupedRooms = collect($rooms)->groupBy('hotel_id')->map(function ($rooms, $hotelId) {
        // İlk oda üzerinden otel bilgilerini alıyoruz
        $hotel = DB::select('SELECT * FROM `hotels` WHERE `id` = :hotel_id', ['hotel_id' => $hotelId])[0];

        return [
          'hotel' => [
            'id' => $hotel->id,
            'name' => $hotel->name,
            'city' => $hotel->city,
            'star' => $hotel->star,
          ],
          'rooms' => $rooms->map(function ($room) {
            return [
              'id' => $room->id,
              'number' => $room->number,
              'bed_count' => $room->bed_count,
              'adult_unit_price' => $room->adult_unit_price,
              'child_unit_price' => $room->child_unit_price,
              'extra_concept_price_adult' => $room->extra_concept_price_adult,
              'extra_concept_price_child' => $room->extra_concept_price_child,
            ];
          }),
        ];
      });

      // Sonuçları JSON formatında döndürüyoruz
      return response([
        'status' => 'true',
        'message' => 'Rooms fetched successfully',
        'data' => $groupedRooms
      ], 200);
    } catch (\Exception $err) {
      return response([
        'status' => 'false',
        'message' => 'Something went wrong',
        'error' => $err->getMessage() . ' ' . $err->getLine() . ' ' . $err->getFile()
      ], 500);
    }
  }
}
