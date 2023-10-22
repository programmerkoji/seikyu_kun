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
        $billing_date = Carbon::parse($date);
        $billing_date_copy = $billing_date->copy();
        $posting_date = $billing_date_copy->subMonths(2);
        $posting_start = $this->faker->dateTimeBetween($posting_date, $date);
        $company_ids = Company::pluck('id')->toArray();

        return [
            'company_id' => $this->faker->randomElement($company_ids),
            'billing_date' => $date,
            'posting_start' => $posting_start,
            'posting_end' => $this->faker->dateTimeBetween($posting_start, '4 week'),
            'detail' => $this->faker->sentence,
            'quantity' => $this->faker->numberBetween(1, 4),
            'price' => $this->faker->numberBetween(28000, 300000),
            'note' => $this->faker->optional(0.3)->realText(),
        ];
    }
}
