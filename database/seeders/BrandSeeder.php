<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $brands = [
            ['name' => 'Zara', 'slug' => 'zara'],
            ['name' => 'H&M', 'slug' => 'hm'],
            ['name' => 'Nike', 'slug' => 'nike'],
            ['name' => 'Adidas', 'slug' => 'adidas'],
        ];

        foreach ($brands as $brand) {
            // Insert if not exists
            Brand::updateOrCreate(
                ['slug' => $brand['slug']], // condition
                ['name' => $brand['name']]  // values to insert/update
            );
        }
    }
}