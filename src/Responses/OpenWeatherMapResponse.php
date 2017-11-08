<?php

namespace Erekle\Weather\Responses;

use Erekle\Weather\Contracts\WeatherResponseInterface;
use Erekle\Weather\Resources\City;
use Erekle\Weather\Traits\ResponseTrait;

class OpenWeatherMapResponse implements WeatherResponseInterface
{

    use ResponseTrait;

    public $weather;

    public $city;

    protected $countryCode;

    protected $cityName;

    protected $zipCode;

    protected $cityId;

    protected $apiVersion;

    protected $endPoint;

    protected $apiKey;

    protected $httpClient;

    protected $cacheTime;

    private $response;

    public function __construct($config, $client)
    {
        $this->apiVersion = $config['api_version'];
        $this->endPoint   = $config['base_url'] . $this->apiVersion;
        $this->apiKey     = $config['api_key'];
        $this->httpClient = $client;
        $this->cacheTime  = $config['cache_time'];
    }

    public function byCityId($cityId)
    {
        $response = $this->getWeatherDataResponse([
            'id' => $cityId,
        ]);

        return json_decode($response->getBody()->getContents());

    }

    public function byZipCode($zipCode, $countryCode)
    {
        $response       = $this->getWeatherDataResponse([
            'zip' => "{$zipCode},{$countryCode}",
        ]);
        $this->response = json_decode($response->getBody()->getContents());

        return $this;

    }

    public function byCityName($cityName)
    {
        $this->cityName = $cityName;
        $response       = $this->getWeatherDataResponse([
            'q' => "{$cityName}",
        ]);

        $this->response = json_decode($response->getBody()->getContents());

        return $this;
    }

    public function setCity(City $city)
    {
        $this->city = $city;
    }

    public function getCity()
    {
        return $this->city;
    }

}


