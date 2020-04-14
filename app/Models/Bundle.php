<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    use Rateable;

    protected $fillable = ['title', 'description'];

    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
}
