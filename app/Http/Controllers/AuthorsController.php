<?php

namespace App\Http\Controllers;
use App\Author;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    public function store(){
        // This is another way 
        Author::create(request()->only([
           "name", "dob",
        ]));
    }

    // protected function validate(){

    // }
}
