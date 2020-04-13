<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index() {
        return Book::all();
    }

    public function show($id) {
        try {
            return Book::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => [
                    'message' => 'Book not found'
                ]
            ], 404);
        }
    }

    public function store(Request $request) {
        $book = new Book();
        $book->title = $request->input('title');
        $book->description = $request->input('description');
        $book->author = $request->input('author');

        $book->save();

        return response()->json(['created' => true], 201);
    }

    public function update(Request $request, $id) {
        try {
            $book = Book::findOrFail($id);
            $book->fill($request->all());
            $book->save();

            return $book;
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => [
                    'message' => 'Book not found'
                ]
            ], 404);
        }
    }

    public function destroy(Request $request, $id) {
        try {
            $book = Book::findOrFail($id);
            $book->delete();

            return response(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => [
                    'message' => 'Book not found'
                ]
            ], 404);
        }
    }
}
