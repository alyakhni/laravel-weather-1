<?php
/**
 * Created by PhpStorm.
 * User: erekle
 * Date: 11/8/17
 * Time: 5:47 PM
 */

namespace Erekle\Weather;


class Wind
{
    public $speed;

    public $degree;

    public function __construct($speed, $degree)
    {
        $this->speed  = $speed;
        $this->degree = $degree;
    }
}