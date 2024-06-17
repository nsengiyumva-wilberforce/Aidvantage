<?php

namespace Database\Factories;

use App\Models\DeliveryProduct;
use App\Models\Delivery;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeliveryProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DeliveryProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'delivery_id' => Delivery::factory(),
            'product_id' => Product::factory(),
            'quantity' => $this->faker->numberBetween(1, 10),
        ];
    }
}
