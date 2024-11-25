<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomOffering extends Model
{
    protected $table = 'room_offerings';

    protected $fillable = [
        'title',
        'description',
        'color_hex_code',
    ];
}
