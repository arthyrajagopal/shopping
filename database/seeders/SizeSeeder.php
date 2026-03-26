<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Size;

use Illuminate\Support\Facades\DB;



class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run()
{
    $sizes = ['S', 'M', 'L', 'XL'];
    foreach ($sizes as $size) {
        Size::create(['name' => $size]);
    }
}
}
