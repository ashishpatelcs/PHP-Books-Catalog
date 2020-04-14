<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Transformers\BookTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index() {
        return $this->collection(Book::all(), new BookTransformer());
    }

    public function show($id) {
        return $this->item(Book::findOrFail($id), new BookTransformer());
    }

    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'author_id' => 'required|exists:authors,id'
        ]);

        $book = new Book();
        $book->title = $request->input('title');
        $book->description = $request->input('description');
        $book->author = $request->input('author');

        $book->save();
        $data = $this->item($book, new BookTransformer());
        return response()->json($data, 201);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'author' => 'required|exists:authors,id'
        ]);

        try {
            $book = Book::findOrFail($id);
            $book->fill($request->all());
            $book->save();

            return $this->item($book, new BookTransformer());

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
