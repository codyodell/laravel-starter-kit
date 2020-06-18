<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Components\File\Models\Product::create([
            'name' => 'Product Name',
            'description' => 'The default product description.',
        ]);
    }
}
