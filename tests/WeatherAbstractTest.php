<?php

namespace Erekle\Weather\Tests;


use Erekle\Weather\Facades\Weather;
use Carbon\Carbon;


class WeatherAbstractTest extends AbstractTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function test_it()
    {

       // Weather::getWeather();
        \Mockery::mock();
    }
}
