<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_categories')->insert([
            [
                'name' => '現金',
                'note' => '',
            ],
            [
                'name' => '振込',
                'note' => '',
            ],
            [
                'name' => '振込手数料',
                'note' => '',
            ]
        ]);
    }
}
