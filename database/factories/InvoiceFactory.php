<?php

namespace Database\Factories;

use App\Models\Company;
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
        $date = $this->faker->dateTimeBetween('-3 month');
        $company_ids = Company::pluck('id')->toArray();

        return [
            'company_id' => $this->faker->randomElement($company_ids),
            'billing_date' => $date,
            'note' => $this->faker->optional(0.3)->realText(),
        ];
    }
}
