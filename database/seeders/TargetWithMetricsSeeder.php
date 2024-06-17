<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TargetWithMetricsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       \App\Models\Target::factory(10)->create();
    }
}
