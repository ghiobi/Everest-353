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
    if(! Auth::guest()){
        return  redirect('/home');
    }
    return view('welcome');
});

Auth::routes();


Route::group(['middleware'=>'auth'], function () {

    Route::get('funds', function(){
        return view('user/funds/add');
    });
    Route::post('funds/add', 'User\FundsController@addFunds');

    Route::group(['middleware' => 'has-funds'], function(){

        Route::get('/home', 'HomeController@index');

        Route::group(['namespace' => 'User'], function(){

            Route::resource('user', 'UserController');

            Route::group(['prefix' => 'mail'], function(){
                Route::get('/', 'MessageController@mailInbox');
                Route::get('/sent', 'MessageController@mailSent');
                Route::get('/compose', 'MessageController@compose');
                Route::post('/', 'MessageController@sendMessage');
            });

            Route::group(['prefix' => 'funds'], function() {
                Route::post('/withdraw', 'FundsController@withdrawFunds');
            });
        });

        // ------------------------------------------------------------------------
        // Resource routes
        // ------------------------------------------------------------------------

        Route::resource('post', 'Post\PostController');

        Route::resource('setting', 'SettingController', ['only' => [
            'index', 'update'
        ]]);

    });
});

Route::get('/images/{path}', function($path, \Illuminate\Http\Request $request) {

    //Image path
    $path = config('image.storage_path') . '\\' . $path;

    //Fetch image object
    $img = null;
    try{
        if ($request->has('w') || $request->has('h')){
            $img = Image::cache(function($image) use($path, $request) {
                $image->make($path)->fit($request->w, $request->h, function($constraint){
                    $constraint->aspectRatio();
                });
            }, 5, true);
        } else {
            $img = Image::make($path);
        }
    } catch (\Intervention\Image\Exception\NotReadableException $e){
        return abort(404);
    }

    //Encode and return response
    $response = Response::make($img->encode('jpg'));
    $response->header('Content-Type', 'image/jpg');

    return $response;
});