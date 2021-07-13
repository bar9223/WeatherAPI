<?php


namespace App\Repository;


use Asana\Errors\NotFoundError;

class WeatherApi
{
    private $currentWeather;
    private const API_SECRET = '23233c1a253148dcb6d91411211307';
    private const URL = 'http://api.weatherapi.com/v1/current.json';

    public function __construct($city)
    {
        $this->validateOpenWeatherUrl($this->createUrl($city));
        $this->setCurrentWeather($city);
    }

    /**
     * @param string $city
     */
    public function setCurrentWeather(string $city) : void
    {
        $this->currentWeather = json_decode(
            file_get_contents($this->createUrl($city, 'weather')),
            true
        );
    }

    /**
     * @return array
     */
    public function getCurrentWeather() : array
    {
        return [
            'city' => $this->currentWeather["location"]["name"],
            'temp' => $this->currentWeather["current"]["temp_c"],
            'pressure' => $this->currentWeather["current"]["pressure_mb"],
            'humidity' => $this->currentWeather["current"]["humidity"],
            'image' => $this->currentWeather["current"]["condition"]["icon"],
            'speed' => $this->currentWeather["current"]["wind_kph"],
            'main_info' => $this->currentWeather["current"]["condition"]["text"],
            'time' => $this->setProperTimeByDate($this->currentWeather["location"]["localtime"])
        ];
    }

    /**
     * @param string $date
     *
     * @return string
     */
    private function setProperTimeByDate(string $date)
    {
        $time = date('H:i',strtotime($date));

        return $time;
    }

    /**
     * @param $city
     *
     * @return string
     */
    private function createUrl($city) :string
    {
        return self::URL.'?key='.self::API_SECRET.'&q='.$city;
    }

    /**
     * @param $url
     *
     * @throws NotFoundError
     */
    private function validateOpenWeatherUrl($url) : void
    {
        if (@file_get_contents($url) === false ) {
            throw new NotFoundError('');
        }
    }
}