<?php

namespace Database\Factories;

use App\Models\ItemOfInterest;
use App\Models\Mapping;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemOfInterestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ItemOfInterest::class;

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
            'quantity' => $this->faker->numberBetween(1, 100),
        ];
    }
}
