<?php

namespace App\Providers;

use App\Interfaces\IWeatherRecommendationService;
use App\Services\WeatherRecommendationsService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IWeatherRecommendationService::class, function (){
            return new WeatherRecommendationsService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
