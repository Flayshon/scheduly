<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date'
    ];
    
    protected $hidden = [
        'owner',
        'created_at',
        'updated_at'
    ];

    public function path()
    {
        return "/events/{$this->id}";
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
