<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['value'];

    public function item()
    {
        return $this->morphTo();
    }
}
