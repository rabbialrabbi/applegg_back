<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        foreach (['Electronics','Kitchen','Home','Office','Outdoor','Floor','Furniture'] as $category) {
            Product::factory()
                ->count(7)
                ->forCategory([
                    'name' => $category,
                ])
                ->create();
        }


    }
}
