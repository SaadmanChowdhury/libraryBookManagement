<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{

    public function store(){

        $data = $this->validateRequest();

        $newBook = Book::create($data);
        return redirect($newBook->path());
    }

    public function update(Book $book){

        $data = $this->validateRequest();   

        $book->update($data);
        return redirect($book->path());
    }

    public function destroy(Book $book){

        $book->delete();
        return redirect("/books");
    }

    protected function validateRequest(){
        
        return request()->validate([
            "title" => "required",
            "author" => "required",
        ]);

    }
}
