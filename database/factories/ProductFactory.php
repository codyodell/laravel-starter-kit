<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

use App\Components\Product\Models\Brand;
use App\Components\Product\Models\Category;
use Illuminate\Support\Str;

$factory->define(Model::class, function (Faker $faker) {

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

    $arProduct = [
        'name' => $faker->unique()->words(rand(1, 3), true),
        'description' => $faker->words(500, true),
        'attributes' => $arAttributes,
        'brand_id' => rand(1, 4),
        'category_id' => rand(1, 8)
    ];

    return $arProduct;
});
