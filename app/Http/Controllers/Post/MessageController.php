<?php

namespace App\Http\Controllers\Post;

use App\Message;
use App\Notifications\HasNewPostComment;
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

        $poster = $post->poster;

        //Notify if poster id is not the same as current user
        if($poster->id != Auth::user()->id){
            $poster->notify(new HasNewPostComment(Auth::user()->fullName(), $post));
        }

        return back();
    }
}
