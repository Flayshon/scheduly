<?php

namespace App\Http\Requests;

use App\Rules\EventRange;
use Illuminate\Foundation\Http\FormRequest;

class StoreTimeSlot extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'event_id' => ['required', 'exists:events,id'],
            'start' => ['required', 'date_format:Y-m-d\TH:i:sP', new EventRange(request('event_id'))],
            'end' => ['required', 'date_format:Y-m-d\TH:i:sP', 'after:start',  new EventRange(request('event_id'))],
            'location_id' => ['required', 'exists:locations,id'],
        ];
    }
}
