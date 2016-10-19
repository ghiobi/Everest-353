<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GeocoderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('geocoder', function(){
            $adapter = new \Ivory\HttpAdapter\Guzzle6HttpAdapter();

            $geocoder = new \Geocoder\ProviderAggregator();
            $geocoder->registerProviders([
                new \Geocoder\Provider\GoogleMaps(
                    $adapter, 'en', 'ca', true, 'AIzaSyARZz-PYaVsJq8CZvykHbaeEtfLbl4IXgg'
                ),

                new \Geocoder\Provider\FreeGeoIp($adapter)
            ]);

            return $geocoder;
        });
    }
}
