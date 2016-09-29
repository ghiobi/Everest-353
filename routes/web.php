<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

// ------------------------------------------------------------------------
// Resource routes
// ------------------------------------------------------------------------

Route::resource('user', 'UserController');

Route::get('/images/{path}', function($path, \Illuminate\Http\Request $request) {

    //Image path
    $path = storage_path('app\public') . '\\' . $path;

    //Fetch image object
    $img = null;
    try{
        if ($request->has('w') || $request->has('h')){
            $img = Image::cache(function($image) use($path, $request) {
                $image->make($path)->resize($request->w, $request->h, function($constraint){
                    $constraint->aspectRatio();
                });
            }, 5, true);
        } else {
            $img = Image::make($path);
        }
    } catch (\Intervention\Image\Exception\NotReadableException $e){
        abort(404);
    }

    //Encode and return response
    $response = Response::make($img->encode('jpg'));
    $response->header('Content-Type', 'image/jpg');

    return $response;
});