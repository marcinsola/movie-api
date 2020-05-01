<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Movie;
use Faker\Generator as Faker;

$factory->define(Movie::class, function (Faker $faker) {
    return [
        'title' => $faker->words($faker->numberBetween(0, 3)),
        'cover' => $faker->imageUrl('240', '240'),
        'description' => $faker->paragraph,
        'country' => $faker->countryCode
    ];
});
