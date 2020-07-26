<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use Faker\Generator as Faker;
use \App\Components\Product\Models\Brand;
use \App\Components\Product\Models\Category;
use \App\Components\User\Models\User;

$factory->define(\App\Components\Product\Models\Product::class, function (Faker $faker) {
    $arAttributes = array();
    $nAttributes = rand(0, 5);
    for ($i = 0; $i <= $nAttributes; $i++) {
        $nAttributeValues = rand(1, 12);
        $strAttributeName = $faker->words(rand(1, 4), true);
        $arAttributes[$strAttributeName] = array();
        for ($j = 0; $j <= $nAttributeValues; $j++) {
            $arAttributes[$strAttributeName][] = $faker->words(rand(1, 12), true);
        }
    }
    $nDateVariance = 365 * 2;
    $nDateRandom_Created = rand($nDateVariance, rand($nDateVariance, -1));
    $nDateRandom_Updated = rand($nDateRandom_Created, rand($nDateRandom_Created, -1));
    $users = User::all()->pluck('id')->toArray();
    $brands = Brand::all()->pluck('id')->toArray();
    $categories = Category::all()->pluck('id')->toArray();
    return [
        'name' => ucwords($faker->unique()->words(rand(2, 6), true)),
        'description' => $faker->paragraphs(2, true),
        'price' => $faker->randomFloat(2, 1.99, 399.99),
        'attributes' => $arAttributes,
        'brand_id' => $faker->randomElement($brands),
        'created_by' => $faker->randomElement($users),
        'created_at' => Carbon::now()->subtract($nDateRandom_Created, 'day'),
        'updated_at' => Carbon::now()->subtract($nDateRandom_Updated, 'day'),
    ];
});
