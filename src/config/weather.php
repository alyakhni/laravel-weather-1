<?php


return [

    /*
     * Default Weather Service
     */

    'default' => 'openWeatherMap',


    'connections'  => [

        'openWeatherMap' => [
            'driver'      => 'openweathermap',
            'api_key'     => env('OPENWEATHERMAP_API_KEY',''),
            'api_version' => '2.5',
            'base_url'    => 'http://api.openweathermap.org/data/',
            'cache_time'  => '10' //in minutes
        ],

        'Apixu' => [
            'driver'      => 'apixu',
            'api_key'     =>  env('APIXU_API_KEY',''),
            'base_url'    => 'http://api.apixu.com/',
            'api_version' => 'v1',
            'cache_time'  => '10' //in minutes
        ]
    ],


    /*
     * Default properties
     */
    'city_name'    => 'Tbilisi',
    'country_code' => 'GE',
    'unit'         => 'metric'
];