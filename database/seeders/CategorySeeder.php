<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = ['Electronics', 'Furniture', 'Jewelry', 'Organic', 'Outerwear', 'Pet', 'Sets', 'Shirt'];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => Str::slug($cat)],  // condition
                ['name' => $cat]              // values to insert/update
            );
        }
    }
}