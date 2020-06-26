<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      factory(\App\Components\Product\Models\Category::class, 16)->create();
   }
}
