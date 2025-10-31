<?php

namespace App\Models;

use App\Models\Book;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    public function books(){
        return $this->hasMany(Book::class);
    }
}
