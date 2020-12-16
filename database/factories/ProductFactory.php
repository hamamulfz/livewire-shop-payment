<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        "name" => $faker->word(),
        "description" => $faker->text(120),
        "price" => $faker->numberBetween(20000,2000000),
        "image" => "",
    ];
});
