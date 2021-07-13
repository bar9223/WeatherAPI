<?php


namespace App\Repository;


use Asana\Errors\NotFoundError;

class OpenWeatherApi
{
    private $currentWeather;
    private $weatherForecast;
    private const API_SECRET = '623ab05272f04dfb30f338568094b48b';
    private const URL = 'http://api.openweathermap.org/data/2.5/';
    private const UNIT_TYPE = 'metric';

    public function __construct($city)
    {
        $this->validateOpenWeatherUrl($this->createUrl($city, 'weather'));
        $this->setCurrentWeather($city);
        $this->setWeatherForecast($city);
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
     * @param string $city
     */
    public function setWeatherForecast(string $city) : void
    {
        $this->weatherForecast = json_decode(
            file_get_contents($this->createUrl($city, 'forecast')),
            true
        );
    }

    /**
     * @return string
     */
    public function getWeather() : string
    {
        return $this->currentWeather["weather"][0]["main"];
    }

    /**
     * @return array
     */
    public function getCurrentWeather() : array
    {

        return [
            'city' => $this->currentWeather["name"],
            'temp' => $this->currentWeather["main"]["temp"],
            'pressure' => $this->currentWeather["main"]["pressure"],
            'humidity' => $this->currentWeather["main"]["humidity"],
            'image' => $this->currentWeather["weather"][0]["icon"],
            'speed' => $this->currentWeather["wind"]["speed"],
            'main_info' => $this->getWeather(),
            'time' => $this->setProperTimeByDate($this->currentWeather["dt"])
        ];
    }

    /**
     * @param string $date
     *
     * @return string
     */
    private function setProperTimeByDate(string $date)
    {
        $time = date('H:i', $date);

        return $time;
    }

    /**
     * @return array
     */
    public function getForecast(): array
    {
        $tmp = [];
        $avg = 0;
        $avgP = 0;

        foreach($this->weatherForecast['list'] as $val) {
            $tmpArray = [
                'temp' => $val['main']['temp'],
                'pressure' => $val['main']['pressure']
            ];

            $tmp[date('d.m.Y H:i', $val['dt'])] = $tmpArray;
            $avg += $val['main']['temp'];
            $avgP += $val['main']['pressure'];
        }

        $avg = $avg / count($this->weatherForecast['list']);
        $avgP = $avgP / count($this->weatherForecast['list']);

        $return = [];
        $return['days'] = $tmp;

        $tmpArray = [
            'temp' => $avg,
            'pressure' => $avgP
        ];

        $return['avg'] = $tmpArray;

        return $return;
    }

    /**
     * @param $city
     * @param $type
     *
     * @return string
     */
    private function createUrl($city, $type) :string
    {
        return self::URL . $type .'?q=' . $city . '&units='. self::UNIT_TYPE .'&appid=' . self::API_SECRET;
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