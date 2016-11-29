<?php

namespace App\Http\Controllers;

use App\Library\NearestPostalCode;
use App\Library\PostalCoder;
use App\LocalTrip;
use App\LongDistanceTrip;

use App\Post;
use App\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     *  Welcome Page
     */
    public function welcome()
    {
        //If authenticated redirect to home
        if(! Auth::guest()){
            return  redirect('/home');
        }

        $membership_fee = cache()->remember('settings.user_membership_fee', 10, function(){
            return Setting::find('user_membership_fee')->value;
        });

        return view('welcome', compact('membership_fee'));
    }

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

        $this->validate($request, [
            'postal_start' => 'sometimes|required',
            'radius' => 'sometimes|required|numeric',
            'type' => 'sometimes|required'
        ]);

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

            $postal_start = $postalCoder->geocode(trim($request->postal_start));

            if($postal_start == null){
                return back()->withErrors(['postal_start' => "Couldn't find postal code."]);
            }

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

            $postal_end = $postalCoder->geocode(trim($request->postal_end));

            if($postal_start == null){
                return back()->withErrors(['postal_end' => "Couldn't find postal code."]);
            }

            $ends = $nearestPCoder->nearestUsingCoordinates($postal_end->getLatitude(), $postal_end->getLongitude(), $radius);

            $posts->where(function($query) use ($ends) {
                foreach($ends as $p_code => $distance) {
                    $query->orWhere('destination_pcode', 'like', $p_code . '%');
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

        //Filtering out old posts
        $posts->where(function($query){
            $query->where('one_time', 1);
            $query->whereDate('departure_date', '>=', Carbon::now());
        });
        //Always including frequent posts
        $posts->OrWhere('one_time', 0);

        //Execute Query
        $posts->with('messages')->with('poster')->orderBy('created_at');
        $posts = $posts->get();

        // Get Trips //Not completed trips
        $current_trips = Auth::user()->rides()->whereNull('arrival_datetime')->get();

        // Hosted trips //Not completed trips
        $posted_trips = Auth::user()->hosts()->whereNull('arrival_datetime')->get();

        //Notifications
        $notifications = Auth::user()->unreadNotifications()->get();

        return view('home', compact('posts', 'search', 'current_trips', 'posted_trips', 'notifications'));
    }

    public function clearNotifications(){
        Auth::user()->unreadNotifications()->update(['read_at' => Carbon::now()]);

        return back();
    }

}
