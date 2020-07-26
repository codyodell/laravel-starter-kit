<?php

use Illuminate\Database\Seeder;

use \App\Components\Product\Models\Product;
use \App\Components\Product\Models\Brand;
use \App\Components\Product\Models\Category;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = factory(Product::class, rand(30, 60))->create()
            ->each(function (Product $product) {
                $product->categories()->save(factory(Category::class)->make());
                //$product->brands()->save(factory(Brand::class)->make());
            });
    }
}
