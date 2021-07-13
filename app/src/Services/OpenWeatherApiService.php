<?php


namespace App\Services;


use App\Entity\WeatherStorage;

class OpenWeatherApiService extends AbstractOpenWeatherApi
{
    /**
     * @param array $weatherData
     */
    public function addSeachedWeatherToDb(array $weatherData) : void
    {
        $weatherStorage = new WeatherStorage();
        $weatherStorage->setCity($weatherData['city']);
        $weatherStorage->setTemp($weatherData['temp']);
        $weatherStorage->setDate(new \DateTime('@'.strtotime('now')));

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
                $recentSearches[$key]['date'] = $search->getDate()->format('Y-m-d H:i:s');
            }
        }

        return $recentSearches;
    }
}