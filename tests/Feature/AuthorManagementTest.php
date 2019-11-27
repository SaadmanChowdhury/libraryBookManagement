<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Carbon\Carbon;
use Tests\TestCase;
use App\Author;

class AuthorManagementTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function an_author_can_be_created(){

        $this->withoutExceptionHandling();

        $this->post("/authors",[
            "name" => "Author Name",
            "dob"  => "05/14/1988",
        ]);

        $this->assertCount(1, Author::all());
        $this->assertInstanceOf(Carbon::class, Author::first()->dob);
    }
}
