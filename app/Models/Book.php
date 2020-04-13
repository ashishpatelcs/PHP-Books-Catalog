<?php

namespace App\Models;

class Book extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['title', 'description', 'author'];
}
