<?php

namespace App\Http\Controllers;

use App\Interfaces\IWeatherRecommendationService;

class WeatherRecommendationsController extends Controller
{
    private $weatherRecommendationService;

    public function __construct(IWeatherRecommendationService $weatherRecommendationService)
    {
        $this->weatherRecommendationService = $weatherRecommendationService;
    }

    public function getWeatherRecommendations(string $city)
    {
       /* $recommendations = cache()->remember('recommendations', 60*5, function () use ($city)  {
           return (new WeatherRecommendationsService())->getRecommendation($city); //Gets recommendations from service class function
        });*/

       $recommendations = cache()->remember('recommendations', 60*5, function () use ($city)  {
           return $this->weatherRecommendationService->getRecommendation($city); //Gets recommendations from service class function
       });

        return response()->json(['city' => $city, 'recommendations' => $recommendations], 200);
    }
}
