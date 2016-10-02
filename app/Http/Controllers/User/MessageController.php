<?php

namespace App\Http\Controllers\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Message;
use App\User;
use App\Notifications\HasNewMessage;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Send a message to a user
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function sendMessage(Request $request)
    {
        // Validate request
        $this->validate($request, [
            'recipient_id' => 'required|numeric',
            'body' => 'required'
        ]);

        // Get all parameters from the request
        $sender_id = Auth::user()->id; //The user itself.
        $body = $request->body;
        $recipient_id = $request->recipient_id;

        // From the recipient id, get the user associated with it
        $user = User::find($recipient_id);
        if ($user == null) {
            return back()->withErrors(['recipient_id' => 'Recipient does not exist.']);
        }

        // Create a message
        $message = new Message([
            'sender_id' => $sender_id,
            'body' => $body
        ]);

        // Attach message to user
        $user->messages()->save($message);

        // Notify the recipient user that a new message has arrived
        $user->notify(new HasNewMessage($message));

        // Confirm that the message has been sent successfully
        return back()->with('success', 'Message has been sent.');
    }

    /**
     * Display the mail inbox
     *
     * @return \Illuminate\Http\Response
     */
    public function mailInbox()
    {
        $messages = Auth::user()
            ->messages()
            ->with('sender')
            ->get();

        return view('user.message.mail-inbox', compact('messages'));
    }

    /**
     * Displays mail sent
     *
     * @return string
     */
    public function mailSent()
    {
        //

        return view('user.message.mail-sent', compact('messages'));
    }

    /**
     * Display a compose message view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function compose(Request $request)
    {
        $recipient_id = null;

        if ($request->has('recipient_id')) {
            $recipient_id = $request->recipient_id;
        }

        return view('user.message.compose', compact('recipient_id'));
    }
}
