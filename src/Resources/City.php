<?php

namespace Erekle\Weather\Resources;

class City
{
    public $name;

    public $id;

    public $longitude;

    public $latitude;

    public $country;

    function __construct($id, $name, $longitude, $latitude, $country)
    {
        $this->id        = $id;
        $this->name      = $name;
        $this->longitude = $longitude;
        $this->latitude  = $latitude;
        $this->country   = $country;
    }
}