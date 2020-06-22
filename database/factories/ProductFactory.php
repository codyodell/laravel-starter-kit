<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'name' => $faker->string,
        'description' => $faker->words(500, true),
        'attributes' => [],
        //'created_at' => $faker->dateTime,
        //'updated_at' => $faker->dateTime,
    ];
});
