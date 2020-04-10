<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTimeSlot;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\TimeSlot;
use Illuminate\Support\Facades\DB;

class TimeSlotsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $timeSlots = auth()->user()->events->timeSlots;

        return Inertia::render('Events/Index', [
            'timeSlots' => $timeSlots
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTimeSlot $request)
    {
        $slot = $request->validated();

        auth()->user()->timeSlots()->create($slot);

        return redirect('/events');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TimeSlot  $timeSlot
     * @return \Illuminate\Http\Response
     */
    public function show(TimeSlot $timeSlot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TimeSlot  $timeSlot
     * @return \Illuminate\Http\Response
     */
    public function edit(TimeSlot $timeSlot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TimeSlot  $timeSlot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TimeSlot $timeSlot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TimeSlot  $timeSlot
     * @return \Illuminate\Http\Response
     */
    public function destroy(TimeSlot $timeSlot)
    {
        //
    }
}
