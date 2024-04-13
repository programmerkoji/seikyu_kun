<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Company;
use App\Models\Invoice;
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
        Company::factory(30)->create();
        $this->call([
            UserSeeder::class,
            ProductSeeder::class,
            // PostingSeeder::class,
        ]);
        Posting::factory(30)->create();
        // Invoice::factory(100)->create();
    }
}
