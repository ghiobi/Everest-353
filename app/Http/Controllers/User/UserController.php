<?php

namespace App\Http\Controllers\User;

use App\User;
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
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return $users;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        //Return view response
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        if (! $this->canModifyUser($user)){
            return abort(403);
        }

        return view('user.edit', compact('user'));
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
        $user = User::findOrFail($id);

        if (! $this->canModifyUser($user)){
            return abort(403);
        }

        $this->validate($request, [
            '_request' => 'required',
            'first_name' => 'sometimes|required|max:255',
            'last_name' => 'sometimes|required|max:255',
            'email' => 'sometimes|required|email|max:255|unique:users',
            'password' => 'sometimes|required|min:6|confirmed',
            'timezone' => 'required|timezone',
            'is_suspended' => 'sometimes|required|boolean',
            'address' => 'max:255',
            'is_visible_address' => 'sometimes|required|boolean',
            'birth_date' => 'date',
            'is_visible_birth_date' => 'sometimes|required|boolean',
            'license_num' => 'max:255',
            'is_visible_license_num' => 'sometimes|required|boolean',
            'is_visible_policies' => 'sometimes|required|boolean',
            'external_email' => 'max:255|email',
            'is_visible_external_email' => 'sometimes|required|boolean',
            'avatar' => 'dimensions:min_width=300,min_height=300|image|max:5000' //is image type and max file size
        ]);

        switch ($request->_request){
            case 'suspend' :
                if (
                    (Auth::user()->id == $user->id) ||
                    (! Auth::user()->hasRole('admin')) ||
                    (! Auth::user()->hasRole('super-admin') && Auth::user()->hasRole('admin') && $user->hasRole('admin'))
                ){
                    return abort(403);
                }
                $user->update($request->only('is_suspended'));
                return back()->with('success', 'Account has been suspended.');;

            case 'password':
                if(
                    Auth::user()->id != $user->id
                ){
                    return abort(403);
                }
                $user->update(['password' => bcrypt($request->password)]);
                return back()->with('success', 'Password has been changed.');

            case 'profile':

                $user->policies = explode(';', $request->policies);

                if (request()->hasFile('avatar')) {
                    //Generating unique file name.
                    $image_name = spl_object_hash(request()->file('avatar')) . '_' . time() . '.jpg';

                    //Storing image
                    Image::make(request()
                        ->file('avatar'))
                        ->encode('jpg')
                        ->save(config('image.storage_path').'\\'.$image_name);

                    File::delete(config('image.storage_path').'\\'.$user->avatar);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Determines if the current user can modify this user.
     *
     * @param User $user
     * @return bool
     */
    private function canModifyUser(User $user)
    {
        return Auth::user()->id == $user->id || Auth::user()->hasRole('admin');
    }

}
