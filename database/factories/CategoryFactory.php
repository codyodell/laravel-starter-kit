
<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Components\Product\Models\Category::class, function (Faker $faker) {
   return [
      'name' => ucwords($faker->unique()->words(rand(3, 8), true)),
      'description' => $faker->optional()->sentences(rand(1, 4), true),
   ];
});
