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
      factory(\App\Components\Product\Models\Brand::class, 8)->create();
   }
}
