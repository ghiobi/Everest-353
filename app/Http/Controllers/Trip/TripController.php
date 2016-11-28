<?php

namespace App\Http\Controllers\Trip;

use App\Notifications\HasNewTripRating;
use App\Trip;
use Carbon\Carbon;
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
     * Display the specified resource.
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
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $trip = Trip::findOrFail($id);

        if(! $this->canEdit($trip)){
            return abort(403);
        }

        if( empty($trip->arrival_datetime)){
            return abort(500);
        }

        //Complete the trip
        $trip->arrival_datetime = Carbon::now();
        $trip->save();

        return back();
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

                    //Set rating
                    $trip->users()->updateExistingPivot($user->id, ['rating' => $rating]);

                    //Notify the host;
                    $host = $trip->host;
                    $host->notify(new HasNewTripRating($user->first_name, $trip));

                    return back()->with('success', 'Review submitted.');
                }
            }
        }

        return back();
    }

    private function canEdit($trip){
        return Auth::user()->id == $trip->host_id || Auth::user()->hasRole('admin');
    }
}
