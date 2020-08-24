<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'title'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function path()
    {
        return "/locations/{$this->id}";
    }
}
