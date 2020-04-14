<?php

namespace App\Transformers;

use App\Models\Author;
use League\Fractal\TransformerAbstract;

class AuthorTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['books'];

    public function includeBooks(Author $author)
    {
        return $this->collection($author->books, new BookTransformer());
    }

    /**
     * Transform a Author model into an array
     *
     * @param Author $author
     * @return array
     */
    public function transform(Author $author)
    {
        return [
            'id' => $author->id,
            'name' => $author->name,
            'biography' => $author->biography,
            'gender' => $author->gender,
            'rating' => [
                'average' => (float) sprintf("%.2f", $author->ratings()->avg('value')),
                'max' => (float) sprintf("%.2f", 5),
                'percent' => (float) sprintf("%.2f", ($author->ratings()->avg('value') / 5) * 100),
                'count' => $author->ratings()->count()
            ]
        ];
    }
}
