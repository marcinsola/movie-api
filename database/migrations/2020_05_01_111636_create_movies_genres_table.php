<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesGenresTable extends Migration
{
    public function up()
    {
        Schema::create('movies_genres', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movie_id');
            $table->unsignedBigInteger('genre_id');
            $table->timestamps();

            $table->foreign('movie_id')
                ->references('id')
                ->on('movies');

            $table->foreign('genre_id')
                ->references('id')
                ->on('genres');
        });
    }

    public function down()
    {
        Schema::table('movies_genres', function (Blueprint $table) {
           $table->dropForeign(['genre_id', 'movie_id']);
        });

        Schema::dropIfExists('movies_genres');
    }
}
