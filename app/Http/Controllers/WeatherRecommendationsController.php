<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class WeatherRecommendationsController extends Controller
{
    public function getWeatherRecommendations(string $city)
    {
        $startdate = Carbon::tomorrow();
        $enddate = Carbon::tomorrow()->add(3, 'days');
        $response = Http::get("https://api.meteo.lt/v1/places/{$city}/forecasts/long-term");
        $forecasts = json_decode($response->body());
        $i = 0;
        foreach ($forecasts->forecastTimestamps as $forecastTimestamp) {
            $time = Carbon::createFromFormat('Y-m-d H:i:s', $forecastTimestamp->forecastTimeUtc);
            if ($time->hour == 12 && $time->between($startdate, $enddate))
            {
                $recommendations[$i]['weather_forecast'] = $forecastTimestamp->conditionCode;
                $recommendations[$i]['date'] = $time->format('Y-m-d');

                $products = Product::select('sku', 'name', 'price')->take(2)->inRandomOrder()->get()->toArray();
                $recommendations[$i]['products'] = array_values($products);
                $i++;
            }
        }
        return response()->json(['city' => $city, 'recommendations' => $recommendations], 200);
    }
}
