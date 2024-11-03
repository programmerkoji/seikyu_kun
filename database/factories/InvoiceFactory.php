<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Posting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $companyIds = Company::pluck('id')->toArray();

        return [
            'company_id' => $this->faker->randomElement($companyIds),
            'title' => $this->faker->title,
            'billing_year' => $this->faker->randomElement([2023, 2024]),
            'billing_month' => $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]),
            'status' => $this->faker->randomElement([1, 2, 3]),
            'note' => $this->faker->optional(0.3)->realText(),
        ];
    }
}
