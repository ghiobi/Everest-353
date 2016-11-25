<?php

namespace App\Http\Controllers\Post;

use App\Library\PostalCoder;
use App\LocalTrip;
use App\LongDistanceTrip;
use App\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        //Postal Code Geocoder
        $coder = new PostalCoder();

        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'required|min:10',
            'departure_pcode' => 'required',
            'destination_pcode' => 'required',
            'num_riders' => 'required|numeric',
            'one_time' => 'required|boolean',
            'type' => 'required|boolean'
        ]);

        $departure_pcode = $coder->geocode($request->departure_pcode);
        if (! $departure_pcode){
            return back()->withErrors([
                'departure_pcode' => 'Invalid Postal Code.'
            ]);
        }
        $departure_pcode = $departure_pcode->toArray();

        $destination_pcode = $coder->geocode($request->destination_pcode);
        if (! $destination_pcode){
            return back()->withErrors([
                'destination_pcode' => 'Invalid Postal Code.'
            ]);
        }
        $destination_pcode = $destination_pcode->toArray();

        $post = new Post($request->only([
            'name',
            'description',
            'num_riders',
            'one_time',
        ]));

        //Setting other post attributes.
        $post->departure_pcode = $departure_pcode['postal_code'];
        $post->destination_pcode = $destination_pcode['postal_code'];
        $post->poster_id = Auth::user()->id;
        $post->cost = 90; //TODO: Determine cost of trip per kilometer.
        $post->is_request = false; //TODO: Is request of trip.

        $trip = null;

        //If the request is of type local trip

        if ($request->type)
        {
            $this->validate($request, [
                'every_sun' => 'required_if:one_time,false|boolean',
                'every_mon' => 'required_if:one_time,false|boolean',
                'every_tues' => 'required_if:one_time,false|boolean',
                'every_wed' => 'required_if:one_time,false|boolean',
                'every_thur' => 'required_if:one_time,false|boolean',
                'every_fri' => 'required_if:one_time,false|boolean',
                'every_sat' => 'required_if:one_time,false|boolean',
                'time' => 'required_if:one_time,true',
                'depature_date' => 'required_if:one_time,true:date'
            ]);

            $frequency = $request->only(['every_sun', 'every_mon', 'every_tues', 'every_wed', 'every_thur', 'every_fri', 'every_sat']);
            $frequency = array_values($frequency); //Returns array of the values only

            $trip = new LocalTrip([
                'frequency' => $frequency,
                'departure_time' => (new Carbon($request->time))->toTimeString()
            ]);

            $post->departure_date = $request->departure_date;

        } else {
            //If post is type of long distance

            $this->validate($request, [

            ]);

            $trip = new LongDistanceTrip([
                'departure_city' => $departure_pcode['city'],
                'departure_province' => $departure_pcode['province'],
                'destination_city' => $destination_pcode['city'],
                'destination_province' => $destination_pcode['province']
            ]);

        }

        $trip->save();
        $trip->postable()->save($post);

        return redirect(route('post.show', ['post' => $post]))
            ->with('success', 'Your post is now live!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with('postable')->findOrFail($id);

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        if (! $this->canEdit($post)){
            return abort(403);
        }

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if (! $this->canEdit()){
            return abort(403);
        }

        return redirect(route('post.show', ['post' => $post]))
            ->with('success', 'Your post is now live!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect(route('user.show', ['user' => Auth::user()->id]))
            ->with('success', 'Your post has been deleted!');
    }

    private function canEdit(Post $post)
    {
        if($post->poster_id !== Auth::user()->id && ! Auth::user()->hasRole('admin')){
            return false;
        }
        return true;
    }
}
