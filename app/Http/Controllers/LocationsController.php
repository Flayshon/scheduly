<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLocation;
use App\Http\Requests\UpdateLocation;
use App\Location;

class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreLocation  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLocation $request)
    {
        $location = $request->validated();

        auth()->user()->locations()->create($location);

        return redirect('/events');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLocation  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLocation $request, Location $location)
    {
        $location = $request->validated();

        auth()->user()->locations()->update($location);

        return redirect('/events');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        auth()->user()->locations()->delete($location);

        return redirect('/events');
    }
}
