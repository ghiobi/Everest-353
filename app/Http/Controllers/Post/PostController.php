<?php

namespace App\Http\Controllers\Post;

use App\Library\PostalCoder;
use App\LocalTrip;
use App\LongDistanceTrip;
use App\Post;
use Geocoder\Geocoder;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
        return view('posts.create-edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, PostalCoder $coder)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'required|min:10',
            'departure_pcode' => 'required',
            'destination_pcode' => 'required',
            'num_riders' => 'required|numeric'
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
            'num_riders'
        ]));

        $post->departure_pcode = $departure_pcode['postal_code'];
        $post->destination_pcode = $destination_pcode['postal_code'];

        $trip = null;

        if ($request->type == 'local_trip')
        {
            $this->validate($request, [
                'every_sun' => 'required_if:frequent,true|boolean',
                'every_mon' => 'required_if:frequent,true|boolean',
                'every_tues' => 'required_if:frequent,true|boolean',
                'every_wed' => 'required_if:frequent,true|boolean',
                'every_thur' => 'required_if:frequent,true|boolean',
                'every_fri' => 'required_if:frequent,true|boolean',
                'every_sat' => 'required_if:frequent,true|boolean',
                'time' => 'required_if:frequent,false'
            ]);

            $frequency = $request->only(['every_sun', 'every_mon', 'every_tues', 'every_wed', 'every_thur', 'every_fri', 'every_sat']);

            $trip = new LocalTrip([
                'frequency' => $frequency,
                'time' => $request->time
            ]);
        }

        if ($request->type == 'long_distance_trip')
        {
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

        return $post;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
