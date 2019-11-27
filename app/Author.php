<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Author extends Model
{
    protected $guarded = [];

    protected $dates = ["dob"];

    public function setDobAttribute($dob){
        // dd($dob);
        $this->attributes["dob"] = Carbon::parse($dob);
        // dd($this->attributes["dob"]);
    }
}
