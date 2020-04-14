<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use Rateable;

    protected $fillable = ['name', 'gender', 'biography'];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
