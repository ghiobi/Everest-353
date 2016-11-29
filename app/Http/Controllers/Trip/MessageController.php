<?php

namespace App\Http\Controllers\Trip;

use App\Message;
use App\Notifications\HasNewTripComment;
use App\Trip;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function message(Trip $trip, Request $request)
    {
        //Only a admin or the rider can post something.
        if($trip->isRider(Auth::user()) != null && ! Auth::user()->hasRole('admin')){
            return abort(403);
        }

        $this->validate($request, [
            'body' => 'required'
        ]);

        $trip->messages()->save(new Message([
            'sender_id' => Auth::user()->id,
            'body' => $request->body
        ]));

        $host = $trip->host;

        //Notify each user
        if ($host->id != Auth::user()->id) {
            $this->notify($host, $trip);
        }

        foreach ($trip->users as $user){
            if($user->id != Auth::user()->id){
                $this->notify($user, $trip);
            }
        }

        return back();
    }

    private function notify(User $user, Trip $trip)
    {
        $user->notify(new HasNewTripComment(Auth::user()->first_name, $trip));

        //Send Mail
        $user->messages()->save(
            new Message([
                'sender_id' => 1,
                'body' => 'You have received a new message from one of your hosted trips. <a href="/trip/'.$trip->id.'">Click here to visit the page.</a>'
            ])
        );
    }
}
