<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use Rateable;

    protected $fillable = ['title', 'description', 'author_id'];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function bundles()
    {
        return $this->belongsToMany(Bundle::class);
    }
}
