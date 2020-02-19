<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    public function path()
    {
        return "/reservations/{$this->id}";
    }
}
