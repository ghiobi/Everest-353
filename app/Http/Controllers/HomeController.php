<?php

namespace App\Http\Controllers;

use App\Library\NearestPostalCode;
use App\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Performs a search for trips matching criteria found in the request
     * @param Request $request
     */
    public function search(Request $request)
    {

        // Validate request
        $this->validate($request, [
            'departure_postal_code' => 'required',
            'departure_radius' => 'required|numeric',
            'trip_type' => 'required'
        ]);

        // Obtain the request fields
        $departure_postal_code = $request->departure_postal_code;
        $departure_radius = $request->departure_radius;
        $trip_type = $request->trip_type;

        // Update the type of the trip
        if ($trip_type == 'long') {
            $trip_type = 'App\\LongDistanceTrip';
        } elseif ($trip_type == 'short') {
            $trip_type = 'App\\LocalTrip';
        }

        // Obtain all postal codes within the radius, sorted by distance
        $objNearestPostalCode = new NearestPostalCode();
        $nearest_postal_codes = $objNearestPostalCode->nearest($departure_postal_code, $departure_radius);

        // Get all posts, and look from growing distance, if any post have a matching departure postal code
        // Construct the array to be returned
        $posts = Post::all();
        $nearest_posts = array();
        if ($nearest_postal_codes != null) {
            foreach ($nearest_postal_codes as $code => $distance) {
                foreach ($posts as $post) {
                    if (substr($post->departure_pcode,0,3) == $code && $post->postable_type == $trip_type) {
                        $nearest_posts[$post][$distance];
                    }
                }
            }
        }

        return view('home')->with('nearest_posts');
    }
}
