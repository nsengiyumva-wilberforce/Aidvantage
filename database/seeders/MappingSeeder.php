<?php

namespace Database\Seeders;

use App\Models\Mapping;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MappingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mapping::factory()->count(10)->create();
    }
}
