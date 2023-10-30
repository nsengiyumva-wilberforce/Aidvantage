<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //add products related to coffee and coffee machines
        $products = [
            [
                'product_name' => 'Coffee',
                'price' => 9000000,
                'quantity' => 100,
            ],
            [
                'product_name' => 'Coffee Machine',
                'price' => 7500000,
                'quantity' => 100,
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
