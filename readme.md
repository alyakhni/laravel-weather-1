# **Laravel Weather** 

## Installation
Require this package in your composer.json and update composer.
```bash
composer require erekle/weather
```
After updating composer, add the ServiceProvider to the providers array in config/app.php
```bash
Erekle\Weather\WeatherServiceProvider::class,
```
You can use the facade for shorter code. Add this to your aliases:

```bash
'Weather' => Erekle\Weather\Facades\Weather::class,
```
 To publish the config settings in Laravel 5 use:
 ```bash
 php artisan vendor:publish --provider="Erekle\Weather\WeatherServiceProvider::class"
 ```
This will add an weather.php config file to your config folder.


