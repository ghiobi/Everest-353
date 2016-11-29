<?php

namespace App\Http\Controllers\Trip;

use Illuminate\Http\Request;

use App\Trip;
use App\User;
use App\Message;
use App\Setting;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Notifications\HasNewTripRating;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // Process a payment
    public function processPayment(Trip $trip, Request $request)
    {
        // Validate request
        $this->validate($request, [
            'confirm' => 'required'
        ]);

        $errors = [];

        // User must have agreed on terms and cost
        if ($request->confirm == 0) {
            $errors['confirm'] = 'Please agree to the terms and costs of this trip.';
        }
        // Check if the user has enough funds for the trip
        $user = Auth::user(); //The user that wants to attend the trip
        $trip_cost = $trip->cost;
        if ($user->balance < $trip_cost) {
            $errors['balance'] = 'You have insufficient balance on your account to join that trip.';
        }
        // Ensure that there is enough space in the trip
        if(count($trip->users) >= $trip->num_riders) {
            $errors['max_capacity'] = 'The trip has reached its maximum capacity of riders.';
        }
        // Ensure that the departure date is not already passed
        $departure_datetime = strtotime($trip->departure_datetime);
        $now_datetime = strtotime(date('Y-m-d H:i:s'));
        if($now_datetime > $departure_datetime) {
            $errors['late'] = 'The departure date has already passed.';
        }
        // Ensure that the user is not already part of the trip
        foreach($trip->users as $trip_user) {
            if($user->id == $trip_user->id) {
                $errors['already_joined'] = 'You already joined this trip.';
                break;
            }
        }

        // Return if any errors are found
        if (count($errors) > 0){
            return back()->withErrors($errors);
        }

        // Proceed with transaction
        $user->balance -= $trip_cost;
        $user->save();

        $company_income_percentage = Setting::find('company_income_percentage')->value;
        $owner->balance += $trip_cost * (1 - $company_income_percentage);
        $owner->save();

        $system = User::find(1);
        $system->balance += $trip_cost * ($company_income_percentage);
        $system->save();

        // Add that user to the trip
        $trip->users()->attach($user);

        //Notify the hoster
        $host = $trip->host;
        $host->notify(new HasNewTripRating($user->fullName(), $trip));

        //Send Mail
        $host->messages()->save(
            new Message([
                'sender_id' => 1,
                'body' => 'A user has joined a trip! <a href="/post/'.$trip->id.'">Click here to visit the page.</a>'
            ])
        );

        return redirect(route('trip.show', ['trip' => $trip]))
            ->with('success', 'You have successfully joined the trip!');
    }
}
