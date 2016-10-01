<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Message;
use App\Notifications\HasNewMessage;
use App\User;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Send a message to a user
     *
     * @param Request $request
     */
    public function send(Request $request) {

        // Validate request
        $this->validate($request, [
            'sender_id' => 'sometimes|required|numeric',
            'recipient_id' => 'sometimes|required|numeric',
            'body' => 'sometimes|required'
        ]);

        // Get all parameters from the request
        $sender_id = $request->sender_id;
        $body = $request->body;
        $recipient_id = $request->recipient_id;

        // From the recipient id, get the user associated with it
        $user = User::find($recipient_id);

        // Create a message
        $message = new Message(['sender_id'=>$sender_id, 'body'=>$body]);

        // Attach message to user
        $user->messages()->save($message);

        // Notify the recipient user that a new message has arrived
        $user->notify(new HasNewMessage($message));

        // TODO: E-mail sent confirmation view

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {}

    public function sent() { return "Sent";}

    public function compose() {
        return view('messages.compose');
    }
}
