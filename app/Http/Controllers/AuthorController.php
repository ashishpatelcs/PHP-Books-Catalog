<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Rating;
use App\Transformers\AuthorTransformer;
use App\Transformers\RatingTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        return $this->collection(Author::with('ratings')->get(), new AuthorTransformer());
    }

    public function show($id)
    {
        try {
            return $this->item(Author::where('id', $id)->with('ratings')->first(), new AuthorTransformer());
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => [ 'message' => 'Author not found' ]
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'gender' => 'required|in:male,female',
            'biography' => 'required'
        ]);

        try {
            $author = Author::create($request->all());
            $data = $this->item($author, new AuthorTransformer());

            return response()->json($data, 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to store author'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'gender' => 'required|in:male,female',
            'biography' => 'required'
        ]);

        try {
            $author = Author::findOrFail($id);
            $author->fill($request->all());

            $author->save();

            $data = $this->item($author, new AuthorTransformer());
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'error' => [ 'message' => 'Author not found' ]
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $author = Author::findOrFail($id);
            $author->delete();
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => [
                    'message' => 'Author not found'
                ]
            ], 404);
        }
    }

    public function addRating(Request $request, $id) {
        $this->validate($request, [
            'value' => 'required|integer|between:1,5'
        ]);

        try {
            $author = Author::findOrFail($id);

            $rating = $author->ratings()->create(['value' => $request->input('value')]);

            return response()->json(
                $this->item($rating, new RatingTransformer()),
                201
            );
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => [
                    'message' => 'Author not found'
                ]
            ], 404);
        }
    }

    public function removeRating(Request $request, $id, $ratingId)
    {
        try {
            $author = Author::findOrFail($id);
            $author->ratings()->findOrFail($ratingId)->delete();
            return response(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => [
                    'message' => 'Author not found'
                ]
            ], 404);
        }
    }
}
