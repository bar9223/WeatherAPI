<?php

namespace App\Controller;

use App\Entity\OpenWeatherMap;
use App\Repository\OpenWeatherApi;
use App\Repository\WeatherApi;
use App\Services\OpenWeatherApiService;
use Asana\Errors\NotFoundError;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class WeatherController extends AbstractController
{

    private OpenWeatherApiService $openWeatherApiService;

    public function __construct(OpenWeatherApiService $openWeatherApiService)
    {
        $this->openWeatherApiService = $openWeatherApiService;
    }

    /**
     * @Route("/", name="dashboard")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        /**
         * @var OpenWeatherMap $city
         */
        $city = new OpenWeatherMap();

        $form = $this->createFormBuilder($city)
            ->add('city', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Check !'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $city = $form->getData();

            return $this->redirectToRoute('weather_city', [
                'city' => $city->getCity(),
            ]);
        }
        return $this->render('main/weather.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/weather/{city}", name="weather_city", methods={GET})
     *
     * @param string $city
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getWeatherByCity(string $city)
    {
        try {
            /**
             * @var OpenWeatherApi $openWeatherApi
             */
            $openWeatherApi = new OpenWeatherApi($city);
            $weatherApi = new WeatherApi($city);
            $openWeatherResult = $openWeatherApi->getCurrentWeather();
            $weatherApiResult = $weatherApi->getCurrentWeather();
            $this->openWeatherApiService->addSeachedWeatherToDb($openWeatherResult);

            return $this->render('main/result.html.twig', [
                'open_weather' => $openWeatherResult,
                'weather_api' => $weatherApiResult,
                'searches' => $this->openWeatherApiService->getRecentSearches()
            ]);
        } catch (NotFoundError $exception) {
            $errorMessage = 'City not found, try again ! :)';

            return $this->render('errors/errors.html.twig', ['error' => $errorMessage]);
        }

    }
}
