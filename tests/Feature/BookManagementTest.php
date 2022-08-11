<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * > We're making a post request to the `/books` route, with a title and author, and then asserting
     * that the book was added to the database, and that the response was a redirect to the book's path
     */
    public function test_a_book_can_be_added_to_the_library()
    {
        $response = $this->post("/books", [
            "title" => "Cool Book Title",
            "author" => "Cool Author",
        ]);

        $book = Book::first();

        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
    }

    /**
     * We're making a POST request to the /books endpoint, passing in an empty title and a valid
     * author. We're then asserting that the session has errors for the title field
     */
    public function test_a_title_is_required()
    {
        $response = $this->post("/books", [
            "title" => "",
            "author" => "Cool Author",
        ]);

        $response->assertSessionHasErrors("title");
    }

    /**
     * We're posting a book with a title and no author, and we're asserting that the session has an
     * error for the author field
     */
    public function test_an_author_is_required()
    {
        $response = $this->post("/books", [
            "title" => "Cool Book Title",
            "author" => "",
        ]);

        $response->assertSessionHasErrors("author");
    }

    /**
     * We create a book, then we update it, and then we assert that the book has been updated
     */
    public function test_a_book_can_be_updated()
    {
        $this->post("/books", [
            "title" => "Cool Book Title",
            "author" => "Cool Author",
        ]);

        $book = Book::first();

        $response = $this->patch($book->path(), [
            "title" => "New Title",
            "author" => "New Author",
        ]);

        $this->assertEquals("New Title", Book::first()->title);
        $this->assertEquals("New Author", Book::first()->author);

        $response->assertRedirect($book->fresh()->path());
    }

    /**
     * We create a book, assert that there is one book in the database, then delete the book and assert
     * that there are no books in the database
     */
    public function test_a_book_can_be_deleted()
    {
        $this->post("/books", [
            "title" => "Cool Book Title",
            "author" => "Cool Author",
        ]);

        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response = $this->delete($book->path());

        $this->assertCount(0, Book::all());

        $response->assertRedirect("/books");
    }
}
