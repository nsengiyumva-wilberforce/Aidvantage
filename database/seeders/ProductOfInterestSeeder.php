<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductOfInterest;

class ProductOfInterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 10 product_of_interest records
        ProductOfInterest::factory()->count(10)->create();
    }
}
