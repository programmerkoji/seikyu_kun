<?php

namespace Database\Factories;

use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostingApplication>
 */
class PostingApplicationFactory extends Factory
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
            'company_id' => Company::factory(),
            'posting_start' => $date,
            'posting_end' => $this->faker->dateTimeBetween($date, '+4 week'),
            'plan' => $this->faker->numberBetween(1, 5),
            'price' => $this->faker->numberBetween(28000, 300000),
            'area' => $this->faker->numberBetween(1, 4),
            'note' => $this->faker->optional(0.3)->realText(),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
