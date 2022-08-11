<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
    ];

    /**
     * Return the path to the book.
     *
     * @return string.
     */
    public function path()
    {
        return "/books/" . $this->id;
    }
}
