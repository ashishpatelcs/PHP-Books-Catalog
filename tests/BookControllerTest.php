<?php

class BookControllerTest extends TestCase
{
    use \Laravel\Lumen\Testing\DatabaseMigrations;

    /** @test */
    public function index_status_code_should_be_200() {
        $this->get('/books')->seeStatusCode(200);
    }

    /** @test */
    public function index_should_return_collection_of_books() {
        $books = factory(App\Models\Book::class, 2)->create();
        $this->get('/books');
        $expected = [
            'data' => $books->toArray()
        ];
        $this->seeJsonEquals($expected);
    }

    /** @test */
    public function show_should_return_valid_book() {
        $book = factory(App\Models\Book::class)->create();
        $expected = [
            'data' => $book->toArray()
        ];
        $this->get('/books/'.$book->id)
            ->seeStatusCode(200)
            ->seeJson($expected);
        $body = json_decode($this->response->getContent(), true);
        $this->assertArrayHasKey('created_at', $body['data']);
        $this->assertArrayHasKey('updated_at', $body['data']);
    }

    /** @test */
    public function show_should_fail_when_bookid_missing() {
        $this->get('/books/999')
            ->seeStatusCode(404)
            ->seeJson([
                'error' => [
                    'message' => 'Book not found'
                ]
            ]);
    }

    /** @test */
    public function show_route_shouldnt_match_invalid_route() {
        $this->get('/books/this-is-invalid');

        $this->assertNotRegExp(
            '/Book not found/',
            $this->response->getContent(),
            'BookController@show route matching when it should not!'
            );
    }

    /** @test */
    public function store_should_create_new_book_with_status_201() {
        $this->post('/books', [
            'title' => 'Life of legends',
            'description' => 'The saga of legends',
            'author' => 'Ashish Patel'
        ]);
        $this->seeStatusCode(201)->seeJson(['created' => true])->seeInDatabase('books', ['title' => 'Life of legends']);
    }

    /** @test */
    public function update_should_only_change_fillable_fields() {
        $book = factory(App\Models\Book::class)->create([
            'title' => 'War of the Worlds',
            'description' => 'A science fiction masterpiece about Martians invading London',
            'author' => 'H. G. Wells'
        ]);
        $expected = [
            'data' => $book->toArray()
        ];

        $this->put('/books/1', [
            'id' => 5,
            'title' => 'War of the Worlds',
            'description' => 'A science fiction masterpiece about Martians invading London',
            'author' => 'H. G. Wells'
        ]);

        $this->seeStatusCode(200)->seeJson($expected)->seeInDatabase('books', ['title' => 'War of the Worlds']);
    }

    /** @test */
    public function update_should_fail_with_invalid_id() {
        $this->put('/books/999')
            ->seeStatusCode(404)
            ->seeJson([
                'error' => [
                    'message' => 'Book not found'
                ]
            ]);
    }

    /** @test */
    public function update_should_not_match_invalid_route() {
        $this->put('/books/this-is-invalid')->seeStatusCode(404);
    }

    /** @test */
    public function destroy_should_remove_book() {
        $book = factory(App\Models\Book::class)->create();
        $this->delete('/books/'.$book->id)->seeStatusCode(204)->isEmpty();
        $this->notSeeInDatabase('books', ['id' => $book->id]);
    }

    /** @test */
    public function destroy_should_return_404_on_invalid_id() {
        $this->delete('/books/999')->seeStatusCode(404)->seeJson(['error' => ['message' => 'Book not found']]);
    }

    /** @test */
    public function destroy_should_not_match_invalid_route() {
        $this->put('/books/this-is-invalid')->seeStatusCode(404);
    }
}
