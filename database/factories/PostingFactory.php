<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Invoice;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Posting>
 */
class PostingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween('-3 week');
        $contentArray = ['春の感謝キャンペーン適用', 'A,Bプランの長期キャンペーン適用', 'Dプラン1週追加キャンペーン適用'];
        // $companyIds = Company::pluck('id')->toArray();
        $productIds = Product::pluck('id')->toArray();
        $invoices = Invoice::all();
        $invoiceId = $this->faker->randomElement($invoices->pluck('id')->toArray());
        $invoiceArray = $invoices->where('id', $invoiceId)->toArray();
        $invoice = reset($invoiceArray);
        $billingYear = $invoice['billing_year'];
        $billingMonth = $invoice['billing_month'];
        $billingDay = $this->faker->numberBetween(1, 30);
        $postingStart = Carbon::parse($billingYear.'-'.$billingMonth.'-'.$billingDay);
        $companyId = $invoice['company_id'];

        return [
            'company_id' => $companyId,
            'product_id' => $this->faker->randomElement($productIds),
            'invoice_id' => $invoiceId,
            'posting_term' => $this->faker->numberBetween(1, 4),
            'posting_start' => $postingStart,
            'quantity' => $this->faker->numberBetween(1, 4),
            'content' => $this->faker->randomElement($contentArray),
            'is_special_price' => $this->faker->numberBetween(0, 1),
            'price' => $this->faker->numberBetween(28000, 300000),
            'note' => $this->faker->optional(0.3)->realText(),
        ];
    }
}
