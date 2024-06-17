<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SaleProduct;

class SaleProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 10 sale_product records
        SaleProduct::factory()->count(10)->create();
    }
}
