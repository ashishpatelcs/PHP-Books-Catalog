<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Bundle;
use App\Transformers\BundleTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BundleController extends Controller {
    public function index()
    {
    }

    public function show($id)
    {
        try {
            $bundle = Bundle::findOrFail($id);

            $data = $this->item($bundle, new BundleTransformer());
            return response()->json($data);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => [ 'message' => 'Bundle not found']
            ], 404);
        }
    }

    public function addBook($id, $bookId)
    {
        try {
            $book = Book::findOrFail($bookId);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => [ 'message' => 'Book not found']
            ], 404);
        }

        try {
            $bundle = Bundle::findOrFail($id);
            $bundle->books()->attach($book);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => [ 'message' => 'Bundle not found']
            ], 404);
        }

        $data = $this->item($bundle, new BundleTransformer());
        return response()->json($data);
    }

    public function removeBook($id, $bookId)
    {
        try {
            $bundle = Bundle::findOrFail($id);
            $bundle->books()->detach($bookId);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => [ 'message' => 'Bundle not found']
            ], 404);
        }

        $data = $this->item($bundle, new BundleTransformer());
        return response()->json($data);
    }
}
