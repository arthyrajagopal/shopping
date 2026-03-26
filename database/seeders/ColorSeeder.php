<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Color;

use Illuminate\Support\Facades\DB;



class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run()
{
    $colors = [
        ['name' => 'Blue', 'code' => '#0000FF'],
        ['name' => 'Green', 'code' => '#00FF00'],
        ['name' => 'Golden', 'code' => '#FFD700'],
        ['name' => 'Red', 'code' => '#FF0000'],
        ['name' => 'Silver', 'code' => '#C0C0C0'],
        ['name' => 'Yellow', 'code' => '#FFFF00'],
        ['name' => 'Cream', 'code' => '#FFFDD0'],
        ['name' => 'Black', 'code' => '#000000'],
        ['name' => 'Brown', 'code' => '#964B00'],
        ['name' => 'Dark Blue', 'code' => '#00008B'],
    ];
    foreach ($colors as $color) {
        Color::create($color);
    }
}
}
