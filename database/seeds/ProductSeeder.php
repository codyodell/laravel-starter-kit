<?php

use Illuminate\Database\Seeder;

use \App\Components\Product\Models\Product;
use \App\Components\Product\Models\Brand;
use \App\Components\Product\Models\Category;
// use \App\Components\User\Models\User;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = factory(Product::class, 50)
            ->create()
            ->each(function (Product $product) {
                //$p->user()->attach(User::all()->random());
                //$p->brand()->attach(Brand::all()->random());
                $product->categories()
                    ->save(factory(Category::class)->make());
            });
    }
}
