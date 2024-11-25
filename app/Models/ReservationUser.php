<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationUser extends Model
{
    protected $table = 'reservation_users';

    protected $fillable = [
        'reservation_id',
        'user_id',
    ];

    /**
     * Get the reservation that owns the reservation user.
     */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    /**
     * Get the user that owns the reservation user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
