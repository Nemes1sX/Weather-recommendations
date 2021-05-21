<?php

namespace App\Http\Controllers;

use App\Services\WeatherRecommendationsService;

class WeatherRecommendationsController extends Controller
{
    public function getWeatherRecommendations(string $city)
    {
        $recommendations = cache()->remember('recommendations', 60*5, function () use ($city)  {
           return (new WeatherRecommendationsService())->getRecommendation($city); //Gets recommendations from service class function
        });
        return response()->json(['city' => $city, 'recommendations' => $recommendations], 200);
    }
}
