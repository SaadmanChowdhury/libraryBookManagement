<?php

namespace Tests\Feature;

use App\Book;
use App\Author;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookManagementTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {

        $this->withoutExceptionHandling();

        $response = $this->post("/books",$this->data());

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

        $response = $this->post(
            "/books",
            array_merge( $this->data(), ["authorId"=>""] ) 
        );

        $response->assertSessionHasErrors("authorId");
    }

    /** @test */
    public function a_book_can_be_updated(){
        $this->withoutExceptionHandling();

        // We know that this will run because:
        // we've already tested a_book_can_be_added_to_the_library already
        $this->post("/books",$this->data());

        $tempBook = Book::first();
        // dd($tempBook->authorId);
        $response=$this->patch($tempBook->path(),[
            "title" => "Update Title",
            "authorId" => "Updated AuthorID",
        ]);
        
        $updatedBook = Book::first();
        // dd($updatedBook->authorId);
        $this->assertEquals("Update Title", $updatedBook ->title);
        $this->assertEquals("2", $updatedBook ->authorId);
        $response->assertRedirect($updatedBook ->path());
    }

    /** @test */
    public function a_book_can_be_deleted(){
        $this->withoutExceptionHandling();

        $this->post("/books",$this->data());

        $tempBook = Book::first();
        $response=$this->delete($tempBook->path());

        $this->assertCount(0, Book::all());
        $response->assertRedirect("/books");
    }

    /** @test */
    public function a_new_author_is_automatically_added(){
        // we make this funciton in the book test because:
        // the book functionality is going to trigger the action tested by this

        $this->withoutExceptionHandling();

        $this->post("/books",[
            "title" =>  "New Title",
            "authorId" => "New Author",
        ]);

        $this->assertEquals(Book::first()->authorId, Author::first()->id);
        $this->assertCount(1, Author::all());
    }

    private function data(){
        return[
            "title"  => "New Title",
            "authorId" => "New AuthorID",
        ];
    }
}
