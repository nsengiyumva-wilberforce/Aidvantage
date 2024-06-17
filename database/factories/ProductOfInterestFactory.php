<?php

namespace Database\Factories;

use App\Models\ProductOfInterest;
use App\Models\Mapping;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductOfInterestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductOfInterest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'business_id' => Mapping::factory(),
            'product_id' => Product::factory(),
        ];
    }
}
