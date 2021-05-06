<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    $name = $faker->realText(rand(30, 40));
    return [
        'parent_id' => rand(0,10),
        'name' => $name,
        'content' => $faker->realText(rand(150, 200)),
        'slug' => Str::slug($name),
    ];
});
