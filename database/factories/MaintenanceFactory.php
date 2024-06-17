<?php

namespace Database\Factories;

use App\Models\Maintenance;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaintenanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Maintenance::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date_of_maintenance' => $this->faker->date,
            'comment' => $this->faker->paragraph,
            'user_id' => User::factory(),
            'visit_id' => Visit::factory(),
        ];
    }
}
