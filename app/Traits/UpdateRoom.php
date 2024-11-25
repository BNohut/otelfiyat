<?php

namespace App\Traits;

use App\Models\HotelRoom;

trait UpdateRoom
{
  public static function boot()
  {
    parent::boot();

    static::created(function ($model) {
      $room = HotelRoom::find($model->hotel_room_id);
      $room->update([
        'check_out_date' => $model->check_out_date,
      ]);
    });
  }
}
