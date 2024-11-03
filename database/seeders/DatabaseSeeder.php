<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Company;
use App\Models\Invoice;
use App\Models\PaymentDetail;
use App\Models\Posting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Company::factory(50)->create();
        $this->call([
            UserSeeder::class,
            ProductSeeder::class,
            PaymentCategorySeeder::class,
            // PostingSeeder::class,
        ]);
        Invoice::factory(100)->create();
        Posting::factory(300)->create();
    }
}
