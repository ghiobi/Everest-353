<?php

namespace App\Http\Middleware;

use App\Setting;
use Closure;
use Illuminate\Support\Facades\Auth;

class HasEnoughFunds
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Activity track
        Auth::user()->touch();
        
        /*
         * Retrieving and storing.
         * https://laravel.com/docs/5.3/cache#retrieving-items-from-the-cache
         */
        $threshold_balance = cache()->remember(
            'settings.user_balance_threshold',
            config('cache.settings'), //minutes found in config/cache.php
            function(){
                return Setting::find('user_balance_threshold')->value;
            }
        );

        if (Auth::user()->balance < $threshold_balance){
            return redirect('funds');
        }

        return $next($request);
    }
}
