<?php

namespace Erekle\Weather\Tests;

use Erekle\Weather\Facades\Weather;
use Mockery as m;

class WeatherAbstractTest extends AbstractTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function test_it()
    {

        m::mock(Weather::class);

    }
}
