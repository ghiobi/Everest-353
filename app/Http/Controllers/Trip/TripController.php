<?php

namespace App\Http\Controllers\Trip;

use App\Trip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Todo make sure the user is part of this trip
        $trip = Trip::with('host')
            ->with('users')
            ->with('messages.sender')
            ->findOrFail($id);

        return view('trips.show', compact('trip'));
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
    }

    public function rate(Trip $trip, Request $request)
    {
        // Validate request
        $this->validate($request, [
            'rating' => 'required|min:1|max:10'
        ]);

        // Obtain the rating
        $rating = $request->rating;

        // Add its rating and check at the same time if the user actually attended the trip
        foreach($trip->users as $user) {
            if($user->id == Auth::user()->id) {
                if($user->pivot->rating == NULL){
                    $trip->users()->updateExistingPivot($user->id, ['rating' => $rating]);
                    return back()->with('success', 'Review submitted.');
                }
            }
        }

        return back();
    }
}
