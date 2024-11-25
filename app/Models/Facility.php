<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Facility extends Model
{
    protected $table = 'facilities';

    protected $fillable = [
        'facility_category_id',
        'title',
        'icon',
    ];

    public function hotels()
    {
        return $this->belongsToMany(Hotel::class, 'hotel_facilities');
    }

    public function category()
    {
        return $this->belongsTo(FacilityCategory::class, 'facility_category_id');
    }
}
