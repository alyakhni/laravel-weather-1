<?php
/**
 * Created by PhpStorm.
 * User: erekle
 * Date: 11/8/17
 * Time: 3:56 PM
 */

namespace Erekle\Weather\Traits;

use Erekle\Weather\Resources\City;

trait ResponseTrait
{
    abstract function setCity();

    abstract function getCity();

    public function getByCityNameAndCountryCode($cityName, $countryCode)
    {
        $response = $this->getWeatherDataResponse([
            'q' => "{$cityName},{$countryCode}",
        ]);

        $this->response = json_decode($response->getBody()->getContents());

        return $this;
    }

    public function getWeatherDataResponse($parameters = [], $isCurrent = FALSE)
    {


        $isCurrent ? $endpoint = $this->endPoint . "/weather" : $endpoint = $this->endPoint . "/forecast";

        $parameters ['appid'] = $this->apiKey;
        $parameters ['units'] = config('weather.unit');

        $response = $this->httpClient->request('GET', $endpoint, ['query' => $parameters]);

        return $response;
    }

    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    protected function weatherSerialize($data, $current = FALSE)
    {

        $weatherArray = [];
        $main = $data->main;
        $weathers = $data->weather;
        if (!$current) {
            if (isset($currentWeather->dt_txt)) {
                $weatherArray['date'] = $data->dt_txt;

            }
            $weatherArray['temp'] = $data->main->temp;
            $weatherArray['temp_min'] = $data->main->temp_min;
            $weatherArray['temp_max'] = $data->main->temp_max;
            $weatherArray['info'] = $data->weather[0];
            $weatherArray['icon'] = "http://openweathermap.org/img/w/" . $data->weather[0]->icon .
                ".png";

            return collect($weatherArray);
        } else {
            $city = new City($data->id, $data->name, $data->coord->lon, $data->coord->lat, $data->sys->country);
            $this->setCity($city);
            $weatherArray['city'] = $this->getCity();

            $weatherArray['temperature'] = $main->temp;
            $weatherArray['temperature_max'] = $main->temp_max;
            $weatherArray['temperature_min'] = $main->temp_min;
            $weatherArray['pressure'] = $main->pressure;
            foreach ($weathers as $key => $weather) {
                $weatherArray['weathers'][$key]['main'] = $weather->main;
                $weatherArray['weathers'][$key]['description'] = $weather->description;
                $weatherArray['weathers'][$key]['icon'] = $weather->icon;
            }


            return collect($weatherArray);

        }
    }

    protected function byDefault()
    {
        $defaultCityName = config('weather.city_name');
        $defaultCountryCode = config('weather.country_code');
        $response = $this->getWeatherDataResponse(['q' => "{$defaultCityName},{$defaultCountryCode}"]);
        $this->response = json_decode($response->getBody()->getContents());

        return $this;
    }

}