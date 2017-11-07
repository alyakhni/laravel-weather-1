<?php


namespace Erekle\Weather\Facades;


use Illuminate\Support\Facades\Facade;

class Weather extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Erekle\\Weather\\Contracts\\WeatherInterface';
    }
}