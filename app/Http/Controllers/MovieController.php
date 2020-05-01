<?php

namespace App\Http\Controllers;

use App\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        return response()->json(Movie::all()->load('genres'));
    }

    public function store(Request $request)
    {
        return response()->json(Movie::create($request->all()), 201);
    }

    public function update(Request $request, Movie $movie)
    {
        $movie->update($request->all());

        return response()->json($movie, 200);
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();

        return response()->json(null, 204);
    }
}
