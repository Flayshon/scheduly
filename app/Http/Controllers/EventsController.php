<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Http\Requests\StoreEvent;
use App\Http\Requests\UpdateEvent;
use Inertia\Inertia;

class EventsController extends Controller
{
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
                    'event_start' => $slot->event->start,
                    'event_end' => $slot->event->end,
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
     * @param  \App\Http\Requests\StoreEvent $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreEvent $request)
    {
        $attributes = $request->validated();

        $event = auth()->user()->events()->create($attributes);

        foreach ($request->input('time_slots') as $timeSlot) {
            $timeSlotAttributes = ['event_id' => $event->id] + $timeSlot;
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
     * @param  \App\Http\Requests\StoreEvent  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateEvent $request, Event $event)
    {
        $this->authorize('update', $event);

        $attributes = $request->validated();

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
