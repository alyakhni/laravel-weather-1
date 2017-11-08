<?php
/**
 * Created by PhpStorm.
 * User: erekle
 * Date: 11/8/17
 * Time: 3:56 PM
 */

namespace Erekle\Weather\Traits;

use Carbon\Carbon;

trait ResponseTrait
{
    abstract function setCity();

    protected function weatherSerialize($weather)
    {

        $currentWeather = $weather;
        $weatherArray   = [];
        if (isset($currentWeather->dt_txt)) {
            $weatherArray['date'] = $currentWeather->dt_txt;

        }
        $weatherArray['temp']     = $currentWeather->main->temp;
        $weatherArray['temp_min'] = $currentWeather->main->temp_min;
        $weatherArray['temp_max'] = $currentWeather->main->temp_max;
        $weatherArray['info']     = $currentWeather->weather[0];
        $weatherArray['icon']     = "http://openweathermap.org/img/w/" . $currentWeather->weather[0]->icon .
                                    ".png";

        return collect($weatherArray);

    }

    public function getByCityNameAndCountryCode($cityName, $countryCode)
    {
        $response = $this->getWeatherDataResponse([
            'q' => "{$cityName},{$countryCode}",
        ]);

        $this->response = json_decode($response->getBody()->getContents());

        return $this;
    }

    public function getWeather($dayNumb = 5)
    {
        $this->getWeatherResponseByProperties();
        $data                     = $this->response;
        $listWeathers             = $data->list;
        $city                     = $data->city;
        $weatherArrays['city']    = $this;
        $weatherArrays['country'] = $city->country;
        $now                      = Carbon::now();
        $current                  = json_decode($this->getWeatherDataResponse(['q' => "{$city->name}"],
            TRUE)->getBody()->getContents());
        $current                  = $this->weatherSerialize($current);
        $current['city']          = $city->name;
        $current['country']       = $city->country;
        $weatherArrays['current'] = (object)$current;


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

    protected function getWeatherResponseByProperties()
    {
        if (!is_null($this->countryCode)) {

            if (!is_null($this->cityName)) {
                $this->getByCityNameAndCountryCode($this->cityName, $this->countryCode);

                return;
            }
            if (!is_null($this->zipCode)) {
                return $this->byZipCode($this->zipCode, $this->countryCode);
            }
        } elseif (!is_null($this->cityId)) {
            return $this->byCityId($this->cityId);
        } elseif (!is_null($this->cityName)) {

            $this->byCityName($this->cityName);

            return;

        }

        return $this->byDefault();
    }

    protected function byDefault()
    {
        $defaultCityName    = config('weather.city_name');
        $defaultCountryCode = config('weather.country_code');
        $response           = $this->getWeatherDataResponse(['q' => "{$defaultCityName},{$defaultCountryCode}"]);
        $this->response     = json_decode($response->getBody()->getContents());

        return $this;

    }

    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    public function getWeatherDataResponse($parameters = [], $isCurrent = FALSE)
    {


        $isCurrent ? $endpoint = $this->endPoint . "/weather" : $endpoint = $this->endPoint . "/forecast";

        $parameters ['appid'] = $this->apiKey;
        $parameters ['units'] = config('weather.unit');

        $response = $this->httpClient->request('GET', $endpoint, ['query' => $parameters]);

        return $response;
    }

}