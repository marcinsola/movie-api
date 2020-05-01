<?php

use App\Genre;
use App\Movie;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $movies = factory(Movie::class, 50)->create();
        $genres = factory(Genre::class, 50)->create();

        $movies->each(function (Movie $movie) use ($genres) {
            $movie->genres()->attach(
                $genres->random(rand(1, 5))->pluck('id')->toArray()
            );
        });
    }
}
