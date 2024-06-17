<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Database\Seeders\TargetSeeder;
use Database\Seeders\ProductSeed;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->call([
            MappingSeeder::class,
            VisitSeeder::class,
            ProductSeeder::class,
            TargetMetricSeeder::class,
            SaleSeeder::class,
            AppointmentSeeder::class,
            DeliverySeeder::class,
            DeliveryProductSeeder::class,
            DemoSeeder::class,
            MaintenanceSeeder::class,
            TargetSeeder::class,
            ItemOfInterestSeeder::class,
            MaintenanceSeeder::class,
            ProductOfInterestSeeder::class,
            SaleProductSeeder::class,
        ]);
    }
}
