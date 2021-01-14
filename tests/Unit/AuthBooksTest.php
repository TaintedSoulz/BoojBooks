<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\User;
use Tests\TestCase;

class AuthBooksTest extends TestCase
{
    public $user;

    public function setUp(): void {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_user_create()
    {
        $this->assertDatabaseHas('users', [
            'email' => $this->user->email
        ]);
    }

    public function test_auth_home()
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->get('/home');

        $response->assertStatus(200);
    }

    public function test_auth_books_page()
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->get('/books');

        $response->assertStatus(200);
    }

    public function test_auth_books_page_add_book()
    {
        $book = Book::factory()->make();

        $this->user->books()->save($book);

        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->get('/books');

        $response->assertStatus(200);
    }

    public function test_auth_books_page_add_book_remove_book()
    {
        $book = Book::factory()->make();

        $this->user->books()->save($book);

        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->get('/books');

        $response->assertStatus(200);

        $book_id = $book->id;
        $book->delete();

        $this->assertDatabaseMissing('books', [
            'id' => $book_id
        ]);

    }

}
