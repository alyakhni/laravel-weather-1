<?php

namespace Erekle\Weather\Tests;


use Erekle\Weather\Contracts\WeatherInterface;
use Erekle\Weather\Facades\Weather;
use Erekle\Weather\WeatherServiceProvider;
use Orchestra\Testbench\TestCase;

abstract class AbstractTestCase extends TestCase
{

    protected $weather;

    protected $app;

    protected function getPackageProviders($app)
    {
        $this->app = $app;

        return [
            WeatherServiceProvider::class
        ];
    }

    public function setUp()
    {
        parent::setUp();
//        $config = [
//            'sitemap.use_cache'      => FALSE,
//            'sitemap.cache_key'      => 'Laravel.Sitemap.',
//            'sitemap.cache_duration' => 3600,
//            'sitemap.testing'        => TRUE
//        ];
//        config($config);
        $this->weather = resolve(WeatherInterface::class);
    }


    protected function getPackageAliases($app)
    {

        return [
            'Weather' => Weather::class
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
    }


}