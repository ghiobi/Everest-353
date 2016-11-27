<?php

namespace App\Http\Controllers\Trip;

use App\Message;
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

        //TODO Notify

        return back();
    }
}
