<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'id' => 1,
                'name' => '北関東Aプラン 4週間',
                'price' => '28000',
            ],
            [
                'id' => 2,
                'name' => '北関東Bプラン 4週間',
                'price' => '41000',
            ],
            [
                'id' => 3,
                'name' => '北関東Cプラン 2週間',
                'price' => '40000',
            ],
            [
                'id' => 4,
                'name' => '北関東Dプラン 2週間',
                'price' => '56000',
            ]
        ]);
    }
}
