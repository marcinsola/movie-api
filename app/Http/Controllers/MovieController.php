<?php

namespace App\Http\Controllers;

use App\Genre;
use App\Movie;
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
            $data = $this->validateData($request);
            $movie = Movie::create($data);

            $genres = Genre::whereIn('id', array_get($data, 'genres'))->pluck('id')->toArray();
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
            $data = $this->validateData($request);
            $movie->update($data);

            $genres = Genre::whereIn('id', array_get($data, 'genres'))->pluck('id')->toArray();
            $movie->genres()->sync($genres);
            DB::commit();

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

    public function findByTitle(Request $request, string $title)
    {
        $movie = Movie::where('title', 'LIKE', '%' . $title . '%')->with('genres')->get();

        return response()->json($movie, 200);
    }

    private function validateData(Request $request)
    {
        return $request->validate([
            'title' => ['required', 'max:255'],
            'genres.*' => ['exists:genres,id']
        ]);
    }
}
