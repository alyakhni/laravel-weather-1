<?php
/**
 * Created by PhpStorm.
 * User: erekle
 * Date: 10/31/17
 * Time: 11:21 AM
 */

namespace App\Services\WeatherService\Contracts;


interface WeatherInterface
{

    public function byCityName($cityName);

    public function byZipCode($zipCode, $countryCode);
}