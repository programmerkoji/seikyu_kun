<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('postings')->insert([
            [
                'id' => 1,
                'company_id' => 2,
                'product_id' => 1,
                'posting_term' => 2,
                'posting_start' => '2024-03-15',
                'quantity' => 1,
                'content' => '感謝キャンペーン適用',
                'is_special_price' => 0,
                'price' => 28000,
                'note' => ''
            ],
            [
                'id' => 2,
                'company_id' => 4,
                'product_id' => 3,
                'posting_term' => 2,
                'posting_start' => '2024-03-04',
                'quantity' => 2,
                'content' => '春の感謝キャンペーン適用',
                'is_special_price' => 1,
                'price' => 40000,
                'note' => '中島さん承認済み'
            ]
        ]);
    }
}
