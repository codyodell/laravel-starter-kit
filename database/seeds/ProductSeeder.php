<?php

use App\Components\Product\Models\Product;
use App\Components\Product\Models\Category;
use App\Components\Product\Models\Brand;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // create brands
        $nBrands = 3;
        $nCategories = 8;
        $brandSeeds = array();
        $brandSeeds[] = Brand::create([
            'name' => ucwords(Str::random(rand(2, 6))),
        ]);
        $categorySeeds = array();
        for ($i = 0; $i < $nCategories; $i++) {
            $categorySeeds[$i] = Category::create([
                'name' => ucwords(Str::random(rand(3, 8)), true),
                'description' => Str::random(200, true),
            ]);
        }
        Product::create([
            'name' => ucwords(Str::random(rand(3, 8)) . ' ' . Str::random(rand(5, 10))),
            'description' => 'The default product description.',
            'attributes' => [],
            'brand_id' => rand(1, $nBrands),
            'category_id' => rand(1, $nCategories),
            'created_by' => 1,
        ]);
    }
}
