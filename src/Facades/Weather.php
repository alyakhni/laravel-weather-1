<?php
/**
 * Created by PhpStorm.
 * User: erekle
 * Date: 10/30/17
 * Time: 12:02 PM
 */

namespace App\Services\WeatherService\Facades;


use App\Services\WeatherService\Contracts\WeatherInterface;
use Illuminate\Support\Facades\Facade;

class Weather extends Facade
{
    protected static function getFacadeAccessor()
    {
        return WeatherInterface::class;
    }
}