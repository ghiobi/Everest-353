<?php

namespace App\Http\Controllers\Trip;

use App\Trip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $trip = Trip::with('post.poster')
            ->with('riders')
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
            'rating' => 'required'
        ]);

        $errors = [];

        // Obtain the rating
        $rating = $request->rating;

        // Check if rating is valid
        if($rating < 0 || $rating > 10) {
            $errors['invalid_rating'] = 'This rating is invalid, rating must be between 0 and 10.';
        }

        // Get the user who is rating
        $user = Auth::user();

        // Add its rating and check at the same time if the user actually attended the trip
        foreach($trip->users as $rider) {
            if($rider->id == $user->id) {
                $rider->pivot->rating = $rating;
                return back()->with('success', 'Message has been sent.');
            }
        }
        $errors['did_not_attend'] = 'You have not attended this trip.';
        return back()->withErrors($errors);
    }
}
