<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacilityCategory extends Model
{
    protected $table = 'facility_categories';

    protected $fillable = [
        'title',
        'description',
    ];

    /**
     * Hotels relationship.
     */
    public function hotels()
    {
        return $this->belongsToMany(Hotel::class, 'hotel_facilities');
    }
}
