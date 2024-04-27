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
        $company_ids = Company::pluck('id')->toArray();
        $product_ids = Product::pluck('id')->toArray();
        $invoice_ids = Invoice::pluck('id')->toArray();

        return [
            'company_id' => $this->faker->randomElement($company_ids),
            'product_id' => $this->faker->randomElement($product_ids),
            'invoice_id' => $this->faker->randomElement($invoice_ids),
            'posting_term' => $this->faker->numberBetween(1, 4),
            'posting_start' => $this->faker->dateTimeBetween('-3 months'),
            'quantity' => $this->faker->numberBetween(1, 4),
            'content' => $this->faker->randomElement($contentArray),
            'is_special_price' => $this->faker->numberBetween(0, 1),
            'price' => $this->faker->numberBetween(28000, 300000),
            'note' => $this->faker->optional(0.3)->realText(),
        ];
    }
}
