<?php

namespace Database\Seeders;

use App\Models\TargetMetric;
use Illuminate\Database\Seeder;

class TargetMetricSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       TargetMetric::factory(10)->create();
    }
}
