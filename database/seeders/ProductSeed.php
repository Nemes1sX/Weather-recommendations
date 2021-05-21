<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'name' => 'Black Umbrella',
                'sku' => 'UM-1',
                'price' => 10.11,
                'category' => 'rain',
            ],
            [
                'name' => 'Pink hat',
                'sku' => 'HAT-15',
                'price' => 6.07,
                'category' => 'rain',
            ],
            [
                'name' => 'Synergistic Leather Hat',
                'sku' => 'UM-13',
                'price' => 94.68,
                'category' => 'sunny',
            ],
            [
                'name' => 'Heavy Duty Iron Hat',
                'sku' => 'UM-18',
                'price' => 10.76,
                'category' => 'sunny',
            ],
        ];
        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }
    }
}
