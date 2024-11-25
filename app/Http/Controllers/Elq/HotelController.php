<?php

namespace App\Http\Controllers\Elq;

use App\Models\Hotel;
use App\Models\HotelRoom;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class HotelController extends Controller
{
    public function getRooms(Request $request)
    {
        try {
            $query = HotelRoom::query();

            // Filtreler
            if ($request->filled('hotel_id')) {
                $query->where('hotel_id', $request->hotel_id);
            }

            if ($request->filled('guest_count')) {
                $query->where('bed_count', '>=', $request->guest_count);
            }

            if ($request->filled('room_offering_ids') && is_array($request->room_offering_ids) && count($request->room_offering_ids) > 0) {
                $query->whereIn('room_offering_id', $request->room_offering_ids);
            }

            if ($request->filled('room_facility_ids') && is_array($request->room_facility_ids) && count($request->room_facility_ids) > 0) {
                $query->whereHas('facilities', function ($q) use ($request) {
                    $q->whereIn('facility_id', $request->room_facility_ids);
                });
            }

            if ($request->filled('hotel_facility_ids' && is_array($request->hotel_facility_ids) && count($request->hotel_facility_ids) > 0)) {
                $query->whereHas('hotel.facilities', function ($q) use ($request) {
                    $q->whereIn('facility_id', $request->hotel_facility_ids);
                });
            }

            if ($request->filled('check_in_date') && $request->filled('check_out_date')) {

                $checkInDate = Carbon::parse($request->check_in_date);
                $checkOutDate = Carbon::parse($request->check_out_date);

                $query->whereDoesntHave('reservations', function ($query) use ($checkInDate, $checkOutDate) {
                    $query->where(function ($query) use ($checkInDate, $checkOutDate) {
                        $query
                            ->whereBetween('check_in_date', [$checkInDate, $checkOutDate])
                            ->orWhereBetween('check_out_date', [$checkInDate, $checkOutDate])
                            ->orwhere(function ($query) use ($checkInDate, $checkOutDate) {
                                $query->where('check_in_date', '<=', $checkInDate)
                                    ->where('check_out_date', '>=', $checkOutDate);
                            });
                    });
                });
            }

            // Sorgu Sonuçlarını Getir
            $rooms = $query->with('hotel')->get();

            // Hotel ID bazında gruplama
            $groupedRooms = $rooms->groupBy('hotel_id')->map(function ($rooms, $hotelId) {
                // İlk oda üzerinden otel bilgilerini al
                $hotel = Hotel::find($hotelId);

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
