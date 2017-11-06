<?php


namespace Erekle\Weather\Contracts;


/**
 * Interface WeatherServiceInterface
 * @package App\Services\WeatherService\Contracts
 */
interface WeatherResponseInterface
{

    /**
     * @param $cityName
     * @param $countryCode
     * @return mixed
     */
    public function getByCityNameAndCountryCode($cityName, $countryCode);

    /**
     * @param $cityName
     * @return mixed
     */
    public function byCityName($cityName);

    /**
     * @param $cityId
     * @return mixed
     */
    public function byCityId($cityId);

    /**
     * @param $zipCode
     * @param $countryCode
     * @return mixed
     */
    public function byZipCode($zipCode, $countryCode);



}