<?php

namespace Database\Factories;

use App\Models\Mapping;
use Illuminate\Database\Eloquent\Factories\Factory;

class MappingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Mapping::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'business_name' => $this->faker->company,
            'business_telephone_contact' => $this->faker->phoneNumber,
            'business_email_contact' => $this->faker->companyEmail,
            'business_location' => $this->faker->city,
            'physical_address' => $this->faker->address,
            'contact_person_name' => $this->faker->name,
            'contact_person_telephone' => $this->faker->phoneNumber,
            'contact_person_email' => $this->faker->email,
            'contact_person_gender' => $this->faker->randomElement(['Male', 'Female', 'Other']),
            'pitch_interest' => $this->faker->sentence,
            'notes' => $this->faker->paragraph,
            'user_id' => \App\Models\User::factory(), // Assuming User factory is also defined
        ];
    }
}
