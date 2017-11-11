<?php

namespace Erekle\Weather\Responses;

use Carbon\Carbon;
use Erekle\Weather\Contracts\WeatherResponseInterface;
use Erekle\Weather\Resources\City;
use Erekle\Weather\Traits\ResponseTrait;

class OpenWeatherMapResponse implements WeatherResponseInterface
{

    use ResponseTrait;

    public $weather;

    public $city;

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

        $response = $this->getWeatherDataResponse([
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

    public function get($dayNumb = 5)
    {
        $data         = $this->getResponse();
        $listWeathers = $data->list;
        $city         = new City(
            $data->city->id,
            $data->city->name,
            $data->city->coord->lat,
            $data->city->coord->lon,
            $data->city->country);
        $this->setCity($city);

        $weatherArrays['city'] = $this->getCity();
        $now                   = Carbon::now();

        foreach ($listWeathers as $listWeather) {
            for ($i = 0; $i < $dayNumb; $i++) {
                $weatherDate = Carbon::createFromTimestamp($listWeather->dt);

                if ($weatherDate->diffInDays($now) == $i) {
                    $weather                          = $this->weatherSerialize($listWeather);
                    $weatherArrays['days'][$i]['day'] = $weatherDate->format('l');
                    $weatherArrays['days'][$i][]      = collect($weather);
                }
            }
        }
        $this->weather = collect($weatherArrays);

        return $this;
    }

    public function current($cityName)
    {
        $response = $this->getWeatherDataResponse(['q' => "{$cityName}"],
            TRUE);

        $this->response = json_decode($response->getBody()->getContents());

        /*
         * Todo make more flexible
         */
        return $this->weatherSerialize($this->response,true);


    }

    protected function getResponse()
    {
        if (is_null($this->response)) {
            $this->byDefault();
        }

        return $this->response;
    }
}


