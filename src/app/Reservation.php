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

    public function path()
    {
        return "/reservations/{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
