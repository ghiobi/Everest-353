<?php

namespace App\Http\Controllers\Trip;

use App\Message;
use App\Notifications\HasNewTripComment;
use App\Trip;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function message(Trip $trip, Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);

        $trip->messages()->save(new Message([
            'sender_id' => Auth::user()->id,
            'body' => $request->body
        ]));

        $host = $trip->host;

        if ($host->id != Auth::user()->id){
            $host->notify(new HasNewTripComment(Auth::user()->first_name, $trip));
        }

        return back();
    }
}
