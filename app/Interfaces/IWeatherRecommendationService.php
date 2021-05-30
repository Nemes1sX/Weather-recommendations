<?php

namespace App\Interfaces;

interface IWeatherRecommendationService {
    public function getRecommendation(string $city);
}