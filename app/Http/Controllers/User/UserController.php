<?php

namespace App\Http\Controllers\User;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(! Auth::user()->hasRole('admin'))
            return abort(403);

        $users = User::all();
        return view('user.index', compact('users'));
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('posts.messages')->findOrFail($id);

        $old_posts = null;
        $old_trips = null;
        $old_hosts = null;

        //Only the user or the administrator can see the user's old things.
        if($this->canEdit($user)){
            //Expired posts.
            $old_posts = $user->posts()
                ->where('one_time', 1)->whereDate('departure_date', '<', Carbon::now())->get();

            //Old trips.
            $old_trips = $user->rides()->whereNotNull('arrival_datetime')->get();

            //Old hosted trips
            $old_hosts = $user->hosts()->whereNotNull('arrival_datetime')->get();
        }

        //Return view response
        return view('user.show', compact('user', 'old_posts', 'old_trips', 'old_hosts'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        if (! $this->canEdit($user)){
            return abort(403);
        }

        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (! $this->canEdit($user)){
            return abort(403);
        }

        $this->validate($request, [
            '_request' => 'required'
        ]);

        switch ($request->_request){
            case 'suspend' :
                if (
                    //If user is the same user
                    (Auth::user()->id == $user->id) ||
                    //Or if user has role admin
                    (! Auth::user()->hasRole('admin')) ||
                    //Only super admin can ban an admin
                    (! Auth::user()->hasRole('super-admin') && $user->hasRole('admin'))
                ){
                    return abort(403);
                }

                //Update suspended attribute.
                $user->is_suspended = ! $user->is_suspended;
                $user->save();

                return back()->with('success', 'Account has been suspended or unsuspended.');;

            case 'password':
                $this->validate($request, [
                    'password' => 'required|min:6|confirmed',
                ]);

                $user->update(['password' => bcrypt($request->password)]);
                return back()->with('success', 'Password has been changed.');

            case 'profile':
                $this->validate($request, [
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'address' => 'max:255',
                    'is_visible_address' => 'required|boolean',
                    'birth_date' => 'date',
                    'is_visible_birth_date' => 'required|boolean',
                    'license_num' => 'max:255',
                    'is_visible_license_num' => 'required|boolean',
                    'is_visible_policies' => 'required|boolean',
                    'external_email' => 'max:255|email',
                    'is_visible_external_email' => 'required|boolean',
                    'avatar' => 'dimensions:min_width=300,min_height=300|image|max:5000' //is image type and max file size
                ]);

                $user->policies = ($request->policies)? explode(';', $request->policies) : [];

                if (request()->hasFile('avatar')) {
                    //Generating unique file name.
                    $image_name = spl_object_hash(request()->file('avatar')) . '_' . time() . '.jpg';

                    //Storing image
                    Image::make(request()
                        ->file('avatar'))
                        ->encode('jpg')
                        ->save(config('image.storage_path').'/'.$image_name);

                    File::delete(config('image.storage_path').'/'.$user->avatar);
                    $user->avatar = $image_name;
                }

                if (empty($request->birth_date)){
                    $user->birth_date = null;
                } else {
                    $user->birth_date = $request->birth_date;
                }

                $user->update($request->except([
                    'password',
                    'is_suspended',
                    'avatar',
                    'policies',
                    'birth_date'
                ]));

                $user->save();
                return back()->with('success', 'Profile has been updated.');
        }

        return abort(403);
    }

    /**
     * Determines if the current user can modify this user.
     * @param User $user
     * @return bool
     */
    private function canEdit(User $user)
    {
        return Auth::user()->id == $user->id || Auth::user()->hasRole('admin');
    }

}
