<?php

namespace Erekle\Weather\Responses;


use Erekle\Weather\Factories\ResponseFactory;
use GuzzleHttp\Client;

/**
 * Class Response
 * @package App\Services\WeatherService\Responses
 */
class WeatherManager
{

    private $config;

    public $api;

    /**
     * @var
     */
    protected $serviceName;

    function __construct($config, Client $client)
    {
        $this->config      = $config;
        $this->serviceName = $this->config['driver'];

        $this->api = ResponseFactory::build($this->serviceName, $config, $client);

    }


    public function __call($name, $arguments)
    {
        return $this->api->$name($arguments[0]);
    }


}