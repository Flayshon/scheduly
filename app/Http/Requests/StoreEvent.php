<?php

namespace App\Http\Requests;

use App\Rules\EventRange;
use Illuminate\Foundation\Http\FormRequest;

class StoreEvent extends FormRequest
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
            'title' => ['required', 'min:3'],
            'description' => ['required', 'min:3'],
            'start' => ['required', 'date_format:Y-m-d'],
            'end' => ['required', 'date_format:Y-m-d', 'after_or_equal:start'],
            'time_slots.*.start' => ['required', 'date_format:Y-m-d\TH:i:sP', new EventRange()],
            'time_slots.*.end' => ['required', 'date_format:Y-m-d\TH:i:sP', 'after:time_slots.*.start', new EventRange()],
            'time_slots.*.location_id' => ['required', 'exists:locations,id'],
        ];
    }
}
