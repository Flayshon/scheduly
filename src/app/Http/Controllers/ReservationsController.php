<?php

namespace App\Http\Controllers;

use App\Reservation;
use Illuminate\Http\Request;

class ReservationsController extends Controller
{
    private $storeValidationRules = [
        'title' => 'required|min:3',
        'description' => 'required|min:3',
        'start_date' => 'required',
        'end_date' => 'required',
        'location_id' => 'required',
        'start' => 'required',
        'end' => 'required',
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

        $timeSlotAttributes = ['reservation_id' => $reservation->id] + $request->only(['location_id', 'start', 'end']);

        $reservation->addTimeSlot($timeSlotAttributes);

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
