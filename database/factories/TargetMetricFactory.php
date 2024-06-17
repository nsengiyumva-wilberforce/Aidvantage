<?php

namespace Database\Factories;

use App\Models\TargetMetric;
use Illuminate\Database\Eloquent\Factories\Factory;

class TargetMetricFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TargetMetric::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Array of possible names
        $names = ['delivery', 'product', 'maintenance'];

        // Randomly select a name
        $name = $this->faker->randomElement($names);

        return [
            'name' => $name,
            'target_value' => $this->faker->numberBetween(1000, 100000),
            'deadline' => $this->faker->date,
        ];
    }
}
