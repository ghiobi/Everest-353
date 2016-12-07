<?php

namespace App\Http\Controllers\User;

use App\Conversation;
use App\Message;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Controlled by the current user and no one else.
 */
class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conversations = Auth::user()->conversations()->with('users')->get();
        $users = User::where('id', '<>', Auth::user()->id)->select(['id', 'first_name', 'last_name', 'avatar'])->get();

        return view('conversations.index', compact('conversations', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'with' => 'required|numeric'
        ]);

        $with = User::find($request->with);

        if($with == null){
            return back()->withErrors(['with' => 'User does not exists']);
        }

        if(Auth::user()->id == $with->id){
            return back()->withErrors(['with' => 'Can\t have a conversation with yourself.']);
        }

        $conversations = Auth::user()->conversations()->with('users')->get();

        foreach ($conversations as $conversation){
            foreach ($conversation->users as $user){
                if($user->id != Auth::user()->id && $conversation->isUser($with)){
                    return back()->withErrors(['with' => 'You already have a conservation with this person.']);
                }
            }
        }

        $conversation = Conversation::create();
        $conversation->users()->attach([Auth::user()->id, $with->id]);

        return redirect('/conversation/' . $conversation->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $conversation = Conversation::with('users')->findOrFail($id);

        //Check if user is in the conversation
        if(! $conversation->isUser(Auth::user())){
            return abort(403);
        }

        $users = [];
        foreach ($conversation->users as $user){
            $users[$user->id] = [
                'name' => $user->fullName(),
                'avatar' => $user->avatarUrl(45)
            ];
        }

        return view('conversations.show', compact('conversation', 'users'));
    }

    /**
     * Gets all messages of the conversation.
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMessages($id, Request $request)
    {
        $conversation = Conversation::with('users')->with('messages')->findOrFail($id);

        //Check if user is in the conversation
        if (! $conversation->isUser(Auth::user())){
            abort(403);
        }

        return response()->json(['conversation' => $conversation]);
    }

    public function SetMessage($id, Request $request)
    {
        $conversation = Conversation::with('users')->findOrFail($id);

        //Check if user is in the conversation
        if (! $conversation->isUser(Auth::user())){
            abort(403);
        }

        $this->validate($request, [
            'body' => 'required'
        ]);

        $conversation->messages()->save(new Message([
            'sender_id' => Auth::user()->id,
            'body' => $request->body
        ]));

        return response()->json(['status' => 'ok']);
    }

}
