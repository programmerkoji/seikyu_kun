<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween('-1year');
        return [
            'name' => $this->faker->company,
            'post_code' => $this->faker->postcode,
            'address' => $this->faker->streetAddress,
            'tel' => $this->faker->phoneNumber,
            'ceo_name' => $this->faker->userName,
            'responsible_person_name' => $this->faker->userName,
            'note' => $this->faker->optional(0.4)->realText,
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
