<?php


namespace Erekle\Weather\Facades;


use Erekle\Weather\Contracts\WeatherInterface;
use Illuminate\Support\Facades\Facade;

class Weather extends Facade
{
    protected static function getFacadeAccessor()
    {


        return WeatherInterface::class;
    }
}