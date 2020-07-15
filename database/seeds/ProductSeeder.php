<?php

use Illuminate\Database\Seeder;

use \App\Components\Product\Models\Product;
use \App\Components\Product\Models\Brand;
use \App\Components\Product\Models\Category;
// use \App\Components\User\Models\User;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = factory(Product::class, rand(35, 75))
            ->create()
            ->each(function (Product $product) {
                $product->categories()->save(factory(Category::class)->make());
                $product->categories()->save(factory(Brand::class)->make());
            });
    }
}
