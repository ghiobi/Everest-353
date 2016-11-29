<?php

namespace App\Http\Controllers\Auth;

use App\Setting;
use App\User;
use Intervention\Image\Facades\Image;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $min_payment = Setting::find('user_membership_fee')->value;
        return Validator::make($data, [
            'payment' => 'required|numeric|min:' . $min_payment,
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'avatar' => 'dimensions:min_width=300,min_height=300|image|max:5000' //is image type and max file size
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $timezone = 'US/EASTERN';
        try{
            //Find user timezone by ip address
            $geoip_timezone = app('geocoder')->using('free_geo_ip')->geocode(request()->ip())
                ->first()
                ->getTimezone();

            //If timezone is not null then overwrite the default timezone
            if(! empty($geoip_timezone))
                $timezone = $geoip_timezone;

        } catch (\Geocoder\Exception\UnsupportedOperation $e){
            //Nothing to do.
        }

        $image_name = null;
        if (request()->hasFile('avatar')) {
            //Generating unique file name.
            $image_name = spl_object_hash(request()->file('avatar')) . '_' . time() . '.jpg';

            //Storing image
            Image::make(request()
                ->file('avatar'))
                ->encode('jpg')
                ->save(config('image.storage_path').'\\'.$image_name);
        }

        //Creating user.
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'avatar' => $image_name,
            'timezone' => $timezone
        ]);
    }
}
