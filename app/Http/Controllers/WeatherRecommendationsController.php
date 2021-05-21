<?php

namespace App\Http\Controllers;

use App\Services\WeatherRecommendationsService;

class WeatherRecommendationsController extends Controller
{
    public function getWeatherRecommendations(string $city)
    {
        $recommendations = (new WeatherRecommendationsService())->getRecommendation($city); //Gets recommendations from service class function

        return response()->json(['city' => $city, 'recommendations' => $recommendations], 200);
    }
}
