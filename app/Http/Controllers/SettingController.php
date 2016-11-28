<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Setting;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Ensure that the user is an administrator
        $this->verifyAdmin();

        $settings = Setting::all();
        return view('settings.index', compact('settings'));
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

        // Ensure that the user is an administrator
        $this->verifyAdmin();

        // Validate
        $this->validate($request, [
            'key' => 'required|numeric'
        ]);

        // Update the setting
        $setting = Setting::findOrFail($id);
        $setting->value = $request->value;

        $setting->save();

        return back()->with('success', 'Settings have been updated successfully!');
    }

    private function verifyAdmin() {
        if(!Auth::user()->hasRole('super-admin')){
            abort(403);
        }
    }
}
