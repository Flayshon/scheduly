<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservation;

class ReservationsController extends Controller
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
        $reservations = auth()->user()->reservations;

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('reservations.create');
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

        $reservation = auth()->user()->reservations()->create($attributes);

        foreach ($request->input('time_slots') as $timeSlot) {
            $timeSlotAttributes = ['reservation_id' => $reservation->id] + $timeSlot;

            $reservation->addTimeSlot($timeSlotAttributes);
        }

        return redirect('/reservations');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
        $this->authorize('view', $reservation);

        return view('reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        $this->authorize('update', $reservation);

        return view('reservations.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        $this->authorize('update', $reservation);

        $attributes = $request->validate($this->updateValidationRules, $request->all());

        $reservation->update($attributes);

        return redirect('/reservations');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        $this->authorize('delete', $reservation);

        $reservation->delete();

        return redirect('/reservations');
    }
}
