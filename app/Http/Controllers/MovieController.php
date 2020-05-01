<?php

namespace App\Http\Controllers;

use App\Genre;
use App\Movie;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use DB;

class MovieController extends Controller
{
    public function index()
    {
        return response()->json(Movie::all()->load('genres'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $movie = Movie::create($request->all());

            $genres = Genre::whereIn('id', $request->get('genres'))->pluck('id')->toArray();
            $movie->genres()->syncWithoutDetaching(array_values($genres));
            DB::commit();

            return response()->json($movie->load('genres'), 201);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(null, 500);
        }
    }

    public function update(Request $request, Movie $movie)
    {
        DB::beginTransaction();
        try {
            $movie->update($request->all());

            $genres = Genre::whereIn('id', $request->get('genres'))->pluck('id')->toArray();
            $movie->genres()->syncWithoutDetaching($genres);
            DB:commit();

            return response()->json($movie->load('genres'), 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(null, 500);
        }
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();

        return response()->json(null, 204);
    }

    public function findByTitle(Request $request)
    {
        try {
            $movie = Movie::where('title', 'LIKE', $request->get('title'))->with('genres')->findOrFail();

            return response()->json($movie, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(null, 404);
        }
    }
}
