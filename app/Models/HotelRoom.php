<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HotelRoom extends Model
{
    protected $table = 'hotel_rooms';

    protected $fillable = [
        'hotel_id',
        'concept_id',
        'room_offering_id',
        'currency_id',
        'number',
        'bed_count',
        'adult_unit_price',
        'child_unit_price',
        'extra_concept_price_adult',
        'extra_concept_price_child',
        'check_out_date'
    ];

    /**
     * Get the hotel that owns the room.
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    /**
     * Get the concept associated with the room.
     */
    public function concept()
    {
        return $this->belongsTo(Concept::class);
    }

    /**
     * Get the room offering associated with the room.
     */
    public function roomOffering()
    {
        return $this->belongsTo(RoomOffering::class);
    }

    /**
     * Get the currency associated with the room.
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * The facilities that belong to the room.
     */
    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'hotel_rooms_facilities');
    }

    /**
     * Get the reservations for the room.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
