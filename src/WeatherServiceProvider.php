<?php

namespace Erekle\Weather;

use Erekle\Weather\Contracts\WeatherInterface;
use Erekle\Weather\Responses\WeatherManager;
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
        $this->publishes([
            __DIR__ . '/config/weather.php' => config_path('weather.php'),
        ], 'weather');
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

    public function provides()
    {
        return [WeatherManager::class];
    }
}
