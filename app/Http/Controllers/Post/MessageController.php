<?php

namespace App\Http\Controllers\Post;

use App\Message;
use App\Post;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function message(Post $post, Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);

        $post->messages()->save(new Message([
            'sender_id' => Auth::user()->id,
            'body' => $request->body
        ]));

        //TODO Notify

        return back();
    }
}
