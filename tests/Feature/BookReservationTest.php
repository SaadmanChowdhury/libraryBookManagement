<?php

namespace Tests\Feature;

use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReservationTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {

        $this->withoutExceptionHandling();

        $response = $this->post("/books",[
            "title"  => "Harry Potter",
            "author" => "J.K. Rowling",
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());
    }

    // public function testBasicTest(){
    //     $response = $this->get("/");
    //     $reponse->assertStatus(true);
    // }
}
