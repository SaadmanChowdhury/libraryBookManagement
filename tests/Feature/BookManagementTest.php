<?php

namespace Tests\Feature;

use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookManagementTest extends TestCase
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

        // $response->assertOk();
        $this->assertCount(1, Book::all());
        $response->assertRedirect(Book::first()->path());
    }

    /** @test */
    public function a_title_is_required(){
        // $this->withoutExceptionHandling();

        $response = $this->post("/books",[
            "title"  => "",
            "author" => "J.K. Rowling",
        ]);

        $response->assertSessionHasErrors("title");
    }

    /** @test */
    public function an_author_is_required(){
        // $this->withoutExceptionHandling();

        $response = $this->post("/books",[
            "title"  => "Harry Potter",
            "author" => "",
        ]);

        $response->assertSessionHasErrors("author");
    }

    /** @test */
    public function a_book_can_be_updated(){
        $this->withoutExceptionHandling();

        // We know that this will run because:
        // we've already tested a_book_can_be_added_to_the_library already
        $this->post("/books",[
            "title"  => "Harry Potter",
            "author" => "J.K. Rowling",
        ]);

        $tempBook = Book::first();

        $response=$this->patch($tempBook->path(),[
            "title" => "New Title",
            "author" => "New Author",
        ]);
        
        $updatedBook = Book::first();

        $this->assertEquals("New Title", $updatedBook ->title);
        $this->assertEquals("New Author", $updatedBook ->author);
        $response->assertRedirect($updatedBook ->path());
    }

    /** @test */
    public function a_book_can_be_deleted(){
        $this->withoutExceptionHandling();

        $this->post("/books",[
            "title"  => "Harry Potter",
            "author" => "J.K. Rowling",
        ]);

        $tempBook = Book::first();
        $response=$this->delete($tempBook->path());

        $this->assertCount(0, Book::all());
        $response->assertRedirect("/books");
    }
}
