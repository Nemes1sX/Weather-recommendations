<?php

namespace App\Http\Controllers;

use App\Services\WeatherRecommendationsService;

class WeatherRecommendationsController extends Controller
{
    public function getWeatherRecommendations(string $city)
    {
        $recommendations = (new WeatherRecommendationsService())->getRecommendation($city);

        return response()->json(['city' => $city, 'recommendations' => $recommendations], 200);
    }
}
