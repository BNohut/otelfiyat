<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency_id',
        'name',
        'email',
        'phone',
        'star',
        'city',
        'district',
        'address',
        'min_child_age',
        'max_child_age',
        'min_accomodation',
        'check_in_time',
        'check_out_time'
    ];

    /**
     * Get the currency associated with the hotel.
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Facilities relationship.
     */
    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'hotel_facilities');
    }
}
