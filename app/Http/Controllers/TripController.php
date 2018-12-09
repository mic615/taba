<?php

namespace App\Http\Controllers;

use App\Http\Resources\Trip as TripResource;
use Illuminate\Http\Request;
use App\Trip;
class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        return TripResource::collection($request->user->trips);
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
    public function store(Request $request)
    {
        //
        $sd = new Carbon\Carbon($request->start_date);
        $ed = new Carbob\Carbon($request->end_date);
        $trip = $request->user()->trips()->create([
          'start_date' => $sd,
          'end_date' => $ed,
          'lat' => $request->lat,
          'long' => $request->long,
          'budget' => $request->budget,
          'city' => $request->city,
          'state' => $request->state,
          'duration' => $sd->diffInDays($ed);
        ]);
        return new TripResource($trip);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        return response()->json(Trip::destroy($id));

    }
}
