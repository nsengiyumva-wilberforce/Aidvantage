<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('target_metrics')->insert([
            [
                'name' => 'Target 1',
                'target_value' => 100,
                'actual_value' => 60,
                'deadline' => '2023-12-19 19:36:54',
                'created_at' => '2021-10-10 08:14:49',
                'updated_at' => '2021-10-10 08:14:49',
            ],
            [
                'name' => 'Target 2',
                'target_value' => 200,
                'actual_value' => 160,
                'deadline' => '2023-12-20 19:36:54',
                'created_at' => '2021-10-10 08:14:49',
                'updated_at' => '2021-10-10 08:14:49',
            ],
            [
                'name' => 'Target 3',
                'target_value' => 300,
                'actual_value' => 100,
                'deadline' => '2023-12-25 19:36:54',
                'created_at' => '2021-10-10 08:14:49',
                'updated_at' => '2021-10-10 08:14:49',
            ],
            [
                'name' => 'Target 4',
                'target_value' => 400,
                'actual_value' => 200,
                'deadline' => '2023-12-30 19:36:54',
                'created_at' => '2021-10-10 08:14:49',
                'updated_at' => '2021-10-10 08:14:49',
            ],
            [
                'name' => 'Target 5',
                'target_value' => 500,
                'actual_value' => 350,
                'deadline' => '2023-12-23 19:36:54',
                'created_at' => '2021-10-10 08:14:49',
                'updated_at' => '2021-10-10 08:14:49',
            ],
        ]);
    }
}
