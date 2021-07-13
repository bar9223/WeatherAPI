<?php


namespace App\Services;

use App\EntityManagers\MainEntityManager;

class AbstractOpenWeatherApi
{
    public $em;

    public function __construct(MainEntityManager $em)
    {
        $this->em = $em;
    }
}