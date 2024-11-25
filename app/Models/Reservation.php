<?php

namespace App\Models;

use App\Traits\UpdateRoom;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use UpdateRoom;

    protected $table = 'reservations';

    protected $fillable = [
        'hotel_room_id',
        'reservation_number',
        'check_in_date',
        'check_out_date',
        'amount',
        'note',
    ];

    protected $appends = [
        'hotel_id',
        'hotel_name',
    ];

    protected $dates = [
        'check_in_date',
        'check_out_date',
    ];

    /**
     * Get the hotel room associated with the reservation.
     */
    public function hotelRoom()
    {
        return $this->belongsTo(HotelRoom::class);
    }

    /**
     * The users that belong to the reservation.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'reservation_users')
            ->withTimestamps();
    }

    /**
     * Get the hotel id.
     *
     * @return int
     */
    public function getHotelIdAttribute()
    {
        return $this->hotelRoom->hotel_id;
    }

    /**
     * Get the hotel name.
     *
     * @return string
     */
    public function getHotelNameAttribute()
    {
        return $this->hotelRoom->hotel->name;
    }
}
