
<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Components\Product\Models\Brand::class, function (Faker $faker) {
   return [
      'name' => ucwords($faker->unique()->words(rand(1, 3), true))
   ];
});
