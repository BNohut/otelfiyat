<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelFacility extends Model
{
    protected $table = 'hotel_facilities';

    protected $fillable = [
        'hotel_id',
        'facility_id',
    ];
}
