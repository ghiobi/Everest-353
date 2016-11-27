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
use Geokit;
use App\Setting;

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
            'departure_date' => 'required|date',
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
        $post->departure_date = $request->departure_date;
        $post->departure_pcode = $departure_pcode['postal_code'];
        $post->destination_pcode = $destination_pcode['postal_code'];
        $post->poster_id = Auth::user()->id;


        // Determine the cost based on distance
        $math = new Geokit\Math();
        $distance = $math->distanceHaversine([$departure_pcode['latitude'], $departure_pcode['longitude']],
            [$destination_pcode['latitude'], $destination_pcode['longitude']])
            ->kilometers();
        $cost = Setting::find('ride_initial_cost')->value + ($distance * Setting::find('fuel_cost_per_kilometer')->value);
        $post->cost = round($cost,2);

        $post->is_request = false; //TODO: Is request of trip.

        $trip = null;

        //TYPE LOCAL TRIP
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
                'time' => 'required|date_format:H:i',
                'departure_date' => 'required_if:one_time,true:date'
            ]);

            $frequency = $request->only(['every_sun', 'every_mon', 'every_tues', 'every_wed', 'every_thur', 'every_fri', 'every_sat']);
            $frequency = array_values($frequency); //Returns array of the values only
            $atLeastOne  = false;
            for($i = 0; $i < count($frequency); $i++) {
                if($frequency[$i]) {
                    $atLeastOne = true;
                }
            }
            if(!$atLeastOne) {
                return back()->withErrors(['frequency' => 'At least one day of the week must be selected.']);
            }

            $trip = new LocalTrip([
                'frequency' => $frequency,
                'departure_time' => (new Carbon($request->time))->toTimeString()
            ]);

        } else {
            //If post is type of long distance

            $this->validate($request, [
                'frequency'=>'required|min:0|max:8'
            ]);

            $trip = new LongDistanceTrip([
                'departure_city' => $departure_pcode['city'],
                'departure_province' => $departure_pcode['province'],
                'destination_city' => $destination_pcode['city'],
                'destination_province' => $destination_pcode['province'],
                'frequency' => $request->frequency
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
        $post = Post::with('postable')
            ->with('messages')->findOrFail($id);

        $trip = null; //TODO $post->getNextTrip();

        return view('posts.show', compact('post', 'trip'));
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

        // Validate
        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'required|min:10',
            'departure_date' => 'required|date',
            'departure_pcode' => 'required',
            'destination_pcode' => 'required',
            'num_riders' => 'required|numeric'
        ]);

        // Updating attributes other than postal code dependent attributes
        $post->name = $request->name;
        $post->description = $request->description;
        $post->departure_date = $request->departure_date;;
        $post->num_riders = $request->num_riders;

        // Avoiding updating the postal codes for nothing
        if($post->departure_pcode != $request->departure_pcode
            || $post->destination_pcode != $request->destination_pcode) {

            // Obtain the new postal coder
            $coder = new PostalCoder();
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

            // Update the postal code
            $post->departure_pcode = $departure_pcode['postal_code'];
            $post->destination_pcode = $destination_pcode['postal_code'];

            // Update the cost based on (new) distance
            $math = new Geokit\Math();
            $distance = $math->distanceHaversine([$departure_pcode['latitude'], $departure_pcode['longitude']],
                [$destination_pcode['latitude'], $destination_pcode['longitude']])
                ->kilometers();
            $cost = Setting::find('ride_initial_cost')->value + ($distance * Setting::find('fuel_cost_per_kilometer')->value);
            $post->cost = round($cost,2);
        }

        $post->save();
        return redirect(route('post.show', ['post' => $post]))
            ->with('success', 'Your post has been updated successfully!');
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
        if(!$this->canEdit($post)) {
            abort(403);
        } else {
            $post->delete();
        }
        // Does not have permission to delete this post
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
