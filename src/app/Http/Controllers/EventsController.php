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
        'start_date' => 'required',
        'end_date' => 'required',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = auth()->user()->events;

        return Inertia::render('Events/Index', [
            'events' => $events,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $request->validate($this->storeValidationRules, $request->all());

        $event = auth()->user()->events()->create($attributes);

        foreach ($request->input('time_slots') as $timeSlot) {
            $timeSlotAttributes = ['event_id' => $event->id] + $timeSlot;

            $event->addTimeSlot($timeSlotAttributes);
        }

        return redirect('/events');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        $this->authorize('view', $event);

        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $this->authorize('update', $event);

        return view('events.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        $event->delete();

        return redirect('/events');
    }
}
