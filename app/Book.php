<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = [];

    public function path(){
        // return "/books/".$this->id."-".$this->title;
        return "/books/".$this->id;
    }

    public function setAuthorIdAttribute($author){
        // firstOrCreate() - a laravel helper function that checks all objects to:
        // send the first equal object, orelse create and return a new object.
        $this->attributes["authorId"] = (Author::firstOrCreate([
            "name" => $author,
        ]))->id;
    }
}
