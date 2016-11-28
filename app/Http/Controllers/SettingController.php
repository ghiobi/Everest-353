<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Setting;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        // Validate
        $this->validate($request, [
            'display_name' => 'required|max:255',
            'description' => 'required|max:255',
            'value' => 'required|max:255'
        ]);

        // Update the setting
        $setting = Setting::findOrFail($id);
        $setting->display_name = $request->display_name;
        $setting->description = $request->description;
        $setting->value = $request->value;

        $setting->save();

        return back()->with('success', 'Settings have been updated successfully!');
    }
}
