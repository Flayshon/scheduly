<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date'
    ];
    
    protected $hidden = [
        'owner'
    ];

    public function path()
    {
        return "/reservations/{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function timeSlots()
    {
        return $this->hasMany(TimeSlot::class);
    }

    public function addTimeSlot($attributes)
    {
        return $this->timeSlots()->create($attributes);
    }
}
