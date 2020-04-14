<?php

namespace App\Transformers;

use App\Models\Rating;
use League\Fractal\TransformerAbstract;

class RatingTransformer extends TransformerAbstract
{
    /**
     * Transform a Rating model into an array.
     *
     * @param Rating $rating
     * @return array
     */
    public function transform(Rating $rating)
    {
        return [
            'id' => $rating->id,
            'value' => $rating->value,
            'item_type' => $rating->item_type,
            'item_id' => $rating->item_id,
            'created' => $rating->created_at->toIso8601String(),
            'updated' => $rating->updated_at->toIso8601String()
        ];
    }
}
