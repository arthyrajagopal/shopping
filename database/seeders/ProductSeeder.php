<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Size;
use App\Models\Review; // <- Add this
use Illuminate\Support\Str;     // <- Add this
use Illuminate\Support\Facades\DB;



class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run()
{
    $faker = \Faker\Factory::create();
    $categories = Category::all();
    $brands = Brand::all();
    $colors = Color::all();
    $sizes = Size::all();

    for ($i = 1; $i <= 20; $i++) {
        $product = Product::create([
            'name' => $faker->unique()->words(3, true),
            'slug' => Str::slug($faker->unique()->words(3, true)),
            'description' => $faker->paragraphs(2, true),
            'price' => $price = $faker->numberBetween(50, 500),
            'sale_price' => $faker->optional(0.7)->numberBetween(20, $price - 10),
            'stock_quantity' => $stock = $faker->numberBetween(10, 100),
            'sold_count' => $faker->numberBetween(0, $stock),
            'image' => 'https://picsum.photos/id/' . rand(1, 200) . '/300/300',            'category_id' => $categories->random()->id,
            'brand_id' => $brands->random()->id,
            'is_trending' => $faker->boolean(30),
            'offer_end_date' => $faker->optional(0.5)->dateTimeBetween('now', '+1 month'),
        ]);

        // Attach random colors (1-3)
        $product->colors()->attach($colors->random(rand(1, 3))->pluck('id')->toArray());
        // Attach random sizes
        $product->sizes()->attach($sizes->random(rand(1, 3))->pluck('id')->toArray());

        // Add 2-3 reviews
        for ($j = 1; $j <= rand(2, 5); $j++) {
            Review::create([
                'product_id' => $product->id,
                'rating' => rand(3, 5),
                'comment' => $faker->sentence(),
                'customer_name' => $faker->name,
            ]);
        }
    }
}
}
