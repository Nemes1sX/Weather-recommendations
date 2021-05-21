<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecommendationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_recommendation()
    {
       $city = 'vilnius';

       $this->json('GET', "api/products/recommended/{$city}", ['Accept' => 'application/json'])
           ->assertStatus(200)
           ->assertJsonStructure([
               'city',
               'recommendations' => [[
                'weather_forecast',
                'date',
                'products' => [[
                    'name',
                    'sku',
                    'price'
                ]],
           ]],
           ]);

    }
}
