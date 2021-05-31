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
       $recommendations = cache()->remember('recommendations', 60*5, function () use ($city)  {
           return $this->weatherRecommendationService->getRecommendation($city); //Gets recommendations from service class function
       });

        return ($recommendations != 'City not found')
            ? response()->json(['city' => $city, 'recommendations' => $recommendations], 200)
            : response()->json(['city' => 'City not found'], 404);
    }
}
