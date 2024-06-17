<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'meeting_date' => $this->faker->date(),
            'meeting_start_time' => $this->faker->time('H:i'),
            'meeting_end_time' => $this->faker->time('H:i'),
            'meeting_notes' => $this->faker->paragraph,
            'user_id' => User::factory(),
            'visit_id' => Visit::factory(),
        ];
    }
}
