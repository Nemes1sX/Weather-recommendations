<?php


namespace App\Services;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class WeatherRecommendationsService
{
    public function getRecommendation(string $city)
    {
        $startdate = Carbon::tomorrow();
        $enddate = Carbon::tomorrow()->add(3, 'days');
        $response = Http::get("https://api.meteo.lt/v1/places/{$city}/forecasts/long-term");
        $forecasts = json_decode($response->body());
        $i = 0;
        $recommendations = [];
        foreach ($forecasts->forecastTimestamps as $forecastTimestamp) {
            $time = Carbon::createFromFormat('Y-m-d H:i:s', $forecastTimestamp->forecastTimeUtc);
            if ($time->hour == 12 && $time->between($startdate, $enddate)) {
                $recommendations[$i]['weather_forecast'] = $forecastTimestamp->conditionCode;
                $recommendations[$i]['date'] = $time->format('Y-m-d');
                if (in_array($forecastTimestamp->conditionCode, ['clear', 'isolated-clouds', 'overcast', 'scattered-clouds'])) {
                    $products = Product::select('sku', 'name', 'price')->where('category', 'sunny')->take(2)
                        ->inRandomOrder()->get()->toArray();
                    $recommendations[$i]['products'] = array_values($products);
                } elseif (in_array($forecastTimestamp->conditionCode, ['light-rain', 'moderate-rain', 'heavy-rain', 'sleet',
                    'light-snow', 'moderate-snow', 'heavy-snow'])) {
                    $products = Product::select('sku', 'name', 'price')->where('category', 'rain')->take(2)
                        ->inRandomOrder()->get()->toArray();
                    $recommendations[$i]['products'] = array_values($products);
                } else {
                    $products = Product::select('sku', 'name', 'price')->take(2)->inRandomOrder()->get()->toArray();
                    $recommendations[$i]['products'] = array_values($products);
                }
                $i++;
            }
        }

        return $recommendations;
    }
}