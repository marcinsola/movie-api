<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Movie;
use Faker\Generator as Faker;

$factory->define(Movie::class, function (Faker $faker) {
    return [
        'title' => $faker->words(rand(1, 3), true),
        'description' => $faker->paragraph,
        'country' => $faker->countryCode
    ];
});
