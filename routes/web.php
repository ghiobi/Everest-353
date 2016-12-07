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

Route::get('/', 'HomeController@welcome');

Auth::routes();


Route::group(['middleware'=>'auth'], function () {

    Route::get('funds', 'User\FundsController@fundsPage');
    Route::post('funds/add', 'User\FundsController@addFunds');

    Route::group(['middleware' => 'has-funds'], function(){

        // ------------------------------------------------------------------------
        // Home
        // ------------------------------------------------------------------------

        Route::get('/home', 'HomeController@index');
        Route::post('notifications/clear', 'HomeController@clearNotifications');

        // ------------------------------------------------------------------------
        // User
        // ------------------------------------------------------------------------

        Route::group(['namespace' => 'User'], function(){

            Route::resource('user', 'UserController', ['except' => [
                'create', 'store', 'destroy'
            ]]);

            Route::group(['prefix' => 'mail'], function(){
                Route::get('/', 'MessageController@mailInbox');
                Route::get('/sent', 'MessageController@mailSent');
                Route::get('/compose', 'MessageController@compose');
                Route::post('/', 'MessageController@sendMessage');
            });

            Route::post('funds/withdraw', 'FundsController@withdrawFunds');

            Route::resource('conversation', 'ConversationController', ['only' => [
                'index', 'store', 'show'
            ]]);
            Route::get('conversation/{id}/get', 'ConversationController@getMessages');
            Route::post('conversation/{id}/set', 'ConversationController@setMessage');
        });

        // ------------------------------------------------------------------------
        // POSTS and TRIPS
        // ------------------------------------------------------------------------

        Route::resource('post', 'Post\PostController');
        Route::post('/post/{post}/message', 'Post\MessageController@message');
        Route::get('/post/{post}/edit', 'Post\PostController@edit');
        Route::get('/post/{post}/delete', 'Post\PostController@destroy');

        Route::resource('trip', 'Trip\TripController', ['except' => [
            'create', 'destroy', 'edit', 'store'
        ]]);
        Route::post('/trip/{trip}/join', 'Trip\PaymentController@processPayment');
        Route::post('/trip/{trip}/message', 'Trip\MessageController@message');
        Route::post('/trip/{trip}/rate', 'Trip\TripController@rate');

        // ------------------------------------------------------------------------
        // Settings
        // ------------------------------------------------------------------------
        Route::resource('setting', 'SettingController', ['only' => [
            'index', 'update'
        ]]);

    });
});

// ------------------------------------------------------------------------
// Image requests, for this to function, web server must be configured.
// ------------------------------------------------------------------------

Route::get('/images/{path}', function($path, \Illuminate\Http\Request $request) {

    //Image path
    $path = config('image.storage_path') . '/' . $path;

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