<?php

namespace App\Http\Controllers;

use App\Library\NearestPostalCode;
use App\Library\PostalCoder;
use App\LocalTrip;
use App\LongDistanceTrip;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, PostalCoder $postalCoder)
    {
        $posts = Post::with('poster');

        //Initialize
        $nearestPCoder = new NearestPostalCode();
        $radius = ($request->radius) ? intval($request->radius) : 25;
        $search = [
            'radius' => $radius,
            'postal_start' => '',
            'postal_end' => ''
        ];

        //Filtering the starting point.

        if($request->postal_start == null){

            //Attempt to find some results automatically.
            $location = null;

            try{
                $location = app('geocoder')->using('free_geo_ip')->geocode((env('APP_DEBUG') ? '132.205.244.34' : $request->ip()))
                    ->first();
            } catch (\Geocoder\Exception\UnsupportedOperation $e) {}

            $starts = $nearestPCoder->nearestUsingCoordinates($location->getLatitude(), $location->getLongitude(), $radius);

            $posts->where(function($query) use ($starts) {
                foreach($starts as $p_code => $distance) {
                    $query->orWhere('departure_pcode', 'like', $p_code . '%');
                }
            });

            $search['postal_start'] = $location->getPostalCode();

        } else {

            $postal_start = $postalCoder->geocode($request->postal_start);

            $starts = $nearestPCoder->nearestUsingCoordinates($postal_start->getLatitude(), $postal_start->getLongitude(), $radius);

            $posts->where(function($query) use ($starts) {
                foreach($starts as $p_code => $distance) {
                    $query->orWhere('departure_pcode', 'like', $p_code . '%');
                }
            });

            $search['postal_start'] = $postal_start->getPostalCode();

        }

        //Filtering the destination.
        if($request->postal_end){

            $postal_end = $postalCoder->geocode($request->postal_end);

            $ends = $nearestPCoder->nearestUsingCoordinates($postal_end->getLatitude(), $postal_end->getLongitude(), $radius);

            $posts->where(function($query) use ($ends) {
                foreach($ends as $p_code => $distance) {
                    $query->orWhere('destination_pcode', 'like', $ends[$i] . '%');
                }
            });

            $search['postal_end'] = $postal_end->getPostalCode();
        }

        //Filtering the post type
        if($request->type == 1){

            $posts->where('postable_type', LocalTrip::class);

        } else if ($request->type == 2) {

            $posts->where('postable_type', LongDistanceTrip::class);

        }

        //Execute Query
        $posts->with('messages')->orderBy('created_at');
        $posts = $posts->get();

        // Get Trips
        $current_trips = Auth::user()->rides()->with('post')->get();

        // Posted trips
        $posted_trips = Auth::user()->postedTrips()->with('post')->get();

        //Notifications
        $notifications = Auth::user()->notifications;

        return view('home', compact('posts', 'search', 'current_trips', 'posted_trips', 'notifications'));
    }

}
