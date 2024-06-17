<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ItemOfInterest;

class ItemOfInterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 10 item_of_interest records
        ItemOfInterest::factory()->count(10)->create();
    }
}
