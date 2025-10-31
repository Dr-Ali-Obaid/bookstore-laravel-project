<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Http\Request;

class AdminsController extends Controller
{
    public function index(){
        $number_of_books = Book::count();
        $number_of_catecogries = Category::count();
        $number_of_publishers = Publisher::count();
        $number_of_authors = Author::count();

        return view('admin.index', compact('number_of_books', 'number_of_catecogries', 'number_of_publishers', 'number_of_authors' ));
    }
}
