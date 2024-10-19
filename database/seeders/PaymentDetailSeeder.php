<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_details')->insert([
            [
                'invoice_id' => 5,
                'payment_category_id' => 1,
                'payment_date' => '2024-11-30',
                'amount' => 28000,
                'note' => 'テスト',
            ],
            [
                'invoice_id' => 10,
                'payment_category_id' => 2,
                'payment_date' => '2024-10-30',
                'amount' => 48000,
                'note' => 'テスト',
            ],
            [
                'invoice_id' => 15,
                'payment_category_id' => 3,
                'payment_date' => '2024-12-30',
                'amount' => 38000,
                'note' => 'テスト',
            ],
        ]);
    }
}
