<?php

namespace App\Models;

/**
 * Trait to enable polymorphic ratings on a model.
 *
 * Trait Item
 * @package App\Models
 */
trait Rateable
{
    public function ratings()
    {
        return $this->morphMany(Rating::class, 'item');
    }
}
