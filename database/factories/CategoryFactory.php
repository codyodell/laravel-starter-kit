
<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Components\Product\Models\Category::class, function (Faker $faker) {
   return [
      'name' => $faker->unique()->name,
      'description' => $faker->words(rand(8, 24), true),
   ];
});
