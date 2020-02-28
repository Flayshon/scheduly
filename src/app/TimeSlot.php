<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    protected $fillable = [
        'location_id',
        'reservation_id',
        'start',
        'end',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function location()
    {
        return $this->hasOne(Location::class, 'id');
    }
}
