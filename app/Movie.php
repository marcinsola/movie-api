<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'cover',
        'description',
        'country'
    ];

    public function genres() {
       return $this->belongsToMany(Genre::class, 'movies_genres');
    }
}
