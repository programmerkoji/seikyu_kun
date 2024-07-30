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
        $postings = Posting::get();
        $postingIds = $postings->pluck('id')->toArray();
        $ramdomPostingId = $this->faker->randomElement($postingIds);
        $billingYear = $postings->firstWhere('id', $ramdomPostingId)?->posting_start ? (int)date('Y', strtotime($postings->firstWhere('id', $ramdomPostingId)->posting_start)) : 0;
        $billingMonth = $postings->firstWhere('id', $ramdomPostingId)?->posting_start ? (int)date('m', strtotime($postings->firstWhere('id', $ramdomPostingId)->posting_start)) : 0;

        return [
            'company_id' => $this->faker->randomElement($companyIds),
            'posting_id' => $ramdomPostingId,
            'title' => $this->faker->title,
            'billing_year' => $billingYear,
            'billing_month' => $billingMonth,
            'note' => $this->faker->optional(0.3)->realText(),
        ];
    }
}
