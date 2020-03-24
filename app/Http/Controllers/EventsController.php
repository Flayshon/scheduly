<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use Inertia\Inertia;

class EventsController extends Controller
{
    private $storeValidationRules = [
        'title' => 'required|min:3',
        'description' => 'required|min:3',
        'start_date' => 'required|date_format:Y-m-d',
        'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
        'time_slots.*.start' => 'required|date_format:Y-m-d H:i',
        'time_slots.*.end' => 'required|date_format:Y-m-d H:i|after_or_equal:time_slots.*.start',
        'time_slots.*.location_id' => 'required|exists:locations,id',
    ];

    private $updateValidationRules = [
        'title' => 'required|min:3',
        'description' => 'required|min:3',
        'start_date' => 'required|date_format:Y-m-d',
        'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $events = auth()->user()->timeSlots()->with('event')->get();

        return Inertia::render('Events/Index', [
            'events' => $events->transform(function ($slot) {
                return [
                    'id' => $slot->id,
                    'event_id' => $slot->event_id,
                    'slot_start' => $slot->start,
                    'slot_end' => $slot->end,
                    'location_id' => $slot->location_id,
                    'event_start' => $slot->event->start_date,
                    'event_end' => $slot->event->start_date,
                    'event_title' => $slot->event->title,
                    'event_description' => $slot->event->description,
                ];
            })
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Events/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $attributes = $request->validate($this->storeValidationRules, $request->all());

        $event = auth()->user()->events()->create($attributes);

        foreach ($request->input('time_slots') as $timeSlot) {
            $timeSlotAttributes = ['event_id' => $event->id] + $timeSlot;
            $timeSlotAttributes['start'] = \Carbon\Carbon::parse($timeSlotAttributes['start'])->format('Y-m-d H:i');
            $timeSlotAttributes['end'] = \Carbon\Carbon::parse($timeSlotAttributes['end'])->format('Y-m-d H:i');
            
            $timeSlotAttributes = ['user_id' => auth()->user()->getAuthIdentifier()] + $timeSlotAttributes;

            $event->addTimeSlot($timeSlotAttributes);
        }

        return redirect('/events');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Inertia\Response
     */
    public function show(Event $event)
    {
        $this->authorize('view', $event);

        return Inertia::render('Events/Show', [
            'event' => $event
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Inertia\Response
     */
    public function edit(Event $event)
    {
        $this->authorize('update', $event);

        return Inertia::render('Events/Edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $attributes = $request->validate($this->updateValidationRules, $request->all());

        $event->update($attributes);

        return redirect('/events');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        $event->delete();

        return redirect('/events');
    }
}
