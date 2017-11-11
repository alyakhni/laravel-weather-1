<?php
/**
 * Created by PhpStorm.
 * User: erekle
 * Date: 11/8/17
 * Time: 5:49 PM
 */

namespace Erekle\Weather\Resources;


use Erekle\Weather\Wind;

class Weather
{

    public $city;

    public $wind;

    public function __construct(City $city, Wind $wind, $otherInfo)
    {

    }
}