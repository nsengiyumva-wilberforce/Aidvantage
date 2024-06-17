<?php

namespace Database\Factories;

use App\Models\Visit;
use App\Models\Mapping;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class VisitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Visit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'business_id' => Mapping::factory(),
            'visit_purpose' => $this->faker->sentence,
            'visit_notes' => $this->faker->paragraph,
            'user_id' => User::factory(),
        ];
    }
}
