<?php

namespace App\Transformers;

use App\Models\Bundle;
use League\Fractal\TransformerAbstract;

class BundleTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['books'];

    public function includeBooks(Bundle $bundle)
    {
        return $this->collection($bundle->books, new BookTransformer());
    }

    /**
     * Transform the Bundle model into an array.
     *
     * @param Bundle $bundle
     * @return array
     */
    public function transform(Bundle $bundle)
    {
        return [
            'id' => $bundle->id,
            'title' => $bundle->title,
            'description' => $bundle->description,
            'created' => $bundle->created_at->toIso8601String(),
            'updated' => $bundle->updated_at->toIso8601String(),
        ];
    }
}
