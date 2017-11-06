<?php
/**
 * Created by PhpStorm.
 * User: erekle
 * Date: 11/3/17
 * Time: 2:25 PM
 */

namespace Erekle\Weather\Factories;


use App\Services\WeatherService\Responses\ApixuResponse;
use App\Services\WeatherService\Responses\OpenWeatherMapResponse;
use GuzzleHttp\Client;

class ResponseFactory
{
    public static function build($type, $config, Client $client)
    {
        $responseObject = "";

        switch ($type) {
            case 'openweathermap':
                $responseObject = new OpenWeatherMapResponse($config, $client);
                break;
            case 'apixu' :
                $responseObject = new ApixuResponse($config, $client);
                break;
        }

        return $responseObject;
    }
}