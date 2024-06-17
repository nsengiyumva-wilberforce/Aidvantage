<?php

namespace Database\Seeders;

use App\Models\DeliveryProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 DeliveryProduct records
        DeliveryProduct::factory()->count(10)->create();
    }
}
