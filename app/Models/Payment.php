<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'reservation_id',
        'payment_method_id',
        'transaction_info',
        'installments'

    ];
}
