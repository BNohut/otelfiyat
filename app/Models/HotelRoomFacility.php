<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelRoomFacility extends Model
{
    protected $table = 'hotel_rooms_facilities';

    protected $fillable = [
        'hotel_room_id',
        'facility_id'
    ];

    /**
     * Get the room that owns the facility.
     */
    public function room()
    {
        return $this->belongsTo(HotelRoom::class, 'hotel_room_id');
    }

    /**
     * Get the facility associated with the room.
     */
    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }
}
