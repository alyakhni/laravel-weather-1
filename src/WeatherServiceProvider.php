<?php

namespace App\Providers;

use App\Services\WeatherService\Contracts\WeatherInterface;
use App\Services\WeatherService\Responses\WeatherManager;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class WeatherServiceProvider extends ServiceProvider
{

    protected $defer = TRUE;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */


    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(WeatherInterface::class, function ($app) {

            $default = $app->config['weather.default'];

            $config = $app->config['weather.connections'][$default];

            return new WeatherManager($config, new Client());
        });
    }


}
