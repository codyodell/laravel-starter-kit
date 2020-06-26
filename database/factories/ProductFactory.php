<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Components\Product\Models\Product::class, function (Faker $faker) {

    $arAttributes = [];
    $nAttributes = rand(2, 6);

    for ($i = 0; $i < $nAttributes; $i++) {
        $nAttributeValues = rand(1, 3);
        $strAttributeName = $faker->words(2, true);
        for ($j = 0; $j < $nAttributeValues; $j++) {
            $arAttributes[$i] = [];
            $arAttributes[$i][$strAttributeName][] = $faker->words(6, true);
        }
    }

    return [
        'name' => $faker->unique()->name,
        'description' => $faker->words(200, true),
        'attributes' => $arAttributes,
        'brand_id' => rand(1, 4),
        'category_id' => rand(1, 8),
        'created_by' => 1
    ];
});
