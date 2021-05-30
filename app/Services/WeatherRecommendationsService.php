<?php


namespace App\Services;

use App\Models\Product;
use App\Interfaces\IWeatherRecommendationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class WeatherRecommendationsService implements IWeatherRecommendationService
{

    public function getRecommendation(string $city)
    {
        $startdate = Carbon::tomorrow();  //Gets tommorow
        $enddate = Carbon::tomorrow()->add(3, 'days'); //Gets 3 days ah of tommorrow
        $response = Http::get("https://api.meteo.lt/v1/places/{$city}/forecasts/long-term");
        $forecasts = json_decode($response->body()); //Getting the body of the forecast
        $i = 0; //Initial index number of recommendations
        $recommendations = [];
        foreach ($forecasts->forecastTimestamps as $forecastTimestamp) {
            $time = Carbon::createFromFormat('Y-m-d H:i:s', $forecastTimestamp->forecastTimeUtc);
            if ($time->hour == 12 && $time->between($startdate, $enddate)) { //Checking if datetime belongs in that period and it's midday
                $recommendations[$i]['weather_forecast'] = $forecastTimestamp->conditionCode;
                $recommendations[$i]['date'] = $time->format('Y-m-d');
                if (in_array($forecastTimestamp->conditionCode, ['clear', 'isolated-clouds', 'overcast', 'scattered-clouds'])) { //If weather is not rainy, it randomly will pick 2 products who fits for sunny weather
                    $products = Product::select('sku', 'name', 'price')->where('category', 'sunny')->take(2)
                        ->inRandomOrder()->get()->toArray();
                    $recommendations[$i]['products'] = array_values($products);
                } elseif (in_array($forecastTimestamp->conditionCode, ['light-rain', 'moderate-rain', 'heavy-rain', 'sleet', //If weather is rainy or snowy, it randomly will pick 2 products who fits for sunny weather
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