<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Reservation;

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
        $this->attributes["author_id"] = (Author::firstOrCreate([
            "name" => $author,
        ]))->id;
    }

    public function checkOut($user){
        // Here, reservations() are referring to a relationship
        $this->reservations()->create([
            "user_id" => $user->id,
            "checked_out_at" => now(),
        ]);
    }

    public function checkin($user){

        $reservation = $this->reservations()
                            ->where("user_id", $user->id)
                            ->whereNotNull("checked_out_at")
                            ->whereNull("checked_in_at")
                            ->first();
        
        if(is_null($reservation)){
            throw new\Exception();
        }

        $reservation->update([
            "checked_in_at" => now(),
        ]);

    }

    // RELATIONSHIP
    public function reservations(){
        return $this->hasMany(Reservation::class);
    }
}
