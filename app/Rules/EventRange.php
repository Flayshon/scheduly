<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class EventRange implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $validRange = DB::table('events')
            ->where('id', '=', $this->eventId)
            ->whereDate('start', '<=', substr($value, 0, strpos($value, 'T')))
            ->whereDate('end', '>=', substr($value, 0, strpos($value, 'T')));

        if ($validRange->exists()) {
            return true;
        }
        
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Date provided is outside the event duration';
    }
}
