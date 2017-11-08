<?php

namespace Erekle\Weather\Resources;

class City
{
    public $name;

    public $id;

    public $longitude;

    public $latitude;

    function __construct($id, $name, $longitude, $latitude)
    {
        $this->id        = $id;
        $this->name      = $name;
        $this->longitude = $longitude;
        $this->latitude  = $latitude;
    }
}