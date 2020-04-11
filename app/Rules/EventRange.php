<?php

namespace App\Rules;

use DateTime;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class EventRange implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($eventId = -1)
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
        $slotDate = new DateTime(substr($value, 0, strpos($value, 'T')));

        if ($this->eventId == -1) {
            $start = new DateTime(request('start'));
            $end = new DateTime(request('end'));

            if ($start<=$slotDate && $slotDate<=$end) {
                return true;
            }

            return false;
        }

        $validRange = DB::table('events')
            ->where('id', '=', $this->eventId)
            ->whereDate('start', '<=', $slotDate)
            ->whereDate('end', '>=', $slotDate);

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
