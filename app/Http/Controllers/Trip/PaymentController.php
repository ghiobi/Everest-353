<?php

namespace App\Http\Controllers\Trip;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
        // Further validation
        if ($request->confirm != 0) {
            $errors['confirm'] = 'Please agree to the terms and costs of this trip.';
        }
        // Check if the user has enough funds for the trip
        $user = Auth::user(); //The user that wants to attend the trip
        $trip_cost = $trip->cost;
        if ($user->balance < $trip_cost) {
            $errors['balance'] = 'You have insufficient balance on your account to join that trip.';
        }

        // Ensure that the user is not already part of the trip
        foreach($trip->users as $trip_user) {
            if($user->id == $trip_user->id) {
                $errors['already_joined'] = 'You are already part of this trip';
            }
        }

        // Return if any errors are found
        if (count($errors) > 0){
            return back()->withErrors($errors);
        }

        // Proceed with transaction
        $user->balance -= $trip_cost;
        $company_income_percentage = Setting::find('company_income_percentage')->value;
        $trip->owner->balance += $trip_cost * (1 - $company_income_percentage);
        User::find(1)->balance += $trip_cost * ($company_income_percentage);

        // Add that user to the trip
        $trip->users()->attach($user);

        return redirect();
    }
}
