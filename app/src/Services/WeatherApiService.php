<?php


namespace App\Services;


use App\Entity\WeatherStorage;

class WeatherApiService extends AbstractOpenWeatherApi
{
    /**
     * @param array $weatherData
     */
    public function addSeachedWeatherToDb(array $weatherData,string $avgTemperature) : void
    {
        $currentTime = new \DateTime('@'.strtotime('now'));
        $currentTimestamp = $currentTime->getTimestamp();
        $weatherStorage = new WeatherStorage();
        $weatherStorage->setCity($weatherData['city']);
        $weatherStorage->setTemp($avgTemperature);
        $weatherStorage->setTimestamp($currentTimestamp);

        $this->em->persist($weatherStorage);
        $this->em->flush();
    }

    /**
     * @return array
     */
    public function getRecentSearches() : array
    {
        /**
         * @var array $searches
         */
        $searches = (array) $this->em->getRepository(WeatherStorage::class)->findBy(
            [],
            [
                'id' => 'DESC'
            ]
        );

        return $this->formatRecentSearches($searches);
    }


    /**
     * @param array $searches
     *
     * @return array
     */
    private function formatRecentSearches(array $searches) : array
    {
        $recentSearches = [];
        if (!empty($searches)) {
            /**
             * @var WeatherStorage $search
             */
            foreach ($searches as $key => $search) {
                $recentSearches[$key]['id'] = $search->getId();
                $recentSearches[$key]['city'] = $search->getCity();
                $recentSearches[$key]['temp'] = $search->getTemp();
                $recentSearches[$key]['date'] = date('Y-m-d H:i:s', $search->getTimestamp());
            }
        }

        return $recentSearches;
    }

    /**
     * @param string $openWeatherTemp
     * @param string $weatherApiTemp
     * @return string
     */
    public function getAvgTemperature(string $openWeatherTemp, string $weatherApiTemp) : string
    {
        $avgTemp = round(((float) $openWeatherTemp + (float) $weatherApiTemp) / 2, 2);

        return (string) $avgTemp;
    }
}