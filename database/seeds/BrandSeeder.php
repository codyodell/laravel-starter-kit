<?php

use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      factory(\App\Components\Product\Models\Brand::class, rand(4, 16))->create();
   }
}
