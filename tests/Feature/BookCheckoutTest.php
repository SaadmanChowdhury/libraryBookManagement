<?php

namespace Tests\Feature;

use App\User;
use App\Book;
use App\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookCheckoutTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_checked_out_by_a_signed_in_user(){
        
        $this->withoutExceptionHandling();

        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user)->post("/checkout/".$book->id);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals(now(), Reservation::first()->checked_out_at);
    }

    /** @test */
    public function only_signed_in_users_can_checkout_a_book(){
        // $this->withoutExceptionHandling();

        $book = factory(Book::class)->create();

        $this->post("/checkout/".$book->id)
            ->assertRedirect("/login");

        $this->assertCount(0, Reservation::all()); 
    }

    /** @test */
    public function only_real_books_can_be_checked_out(){

        $user = factory(User::class)->create();
        $this->actingAs($user)
                ->post("/checkout/123")
                ->assertStatus(404);

        $this->assertCount(0, Reservation::all());
    }
}
