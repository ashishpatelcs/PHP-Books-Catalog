<?php

class BookControllerTest extends TestCase
{
    /** @test */
    public function index_status_code_should_be_200() {
        $this->get('/books')->seeStatusCode(200);
    }

    /** @test */
    public function index_should_return_collection_of_books() {
        $this->get('/books')->seeJson([ 'title' => 'War of the worlds' ]);
    }

    /** @test */
    public function show_should_return_valid_book() {
        $this->get('/books/1')
            ->seeStatusCode(200)
            ->seeJson([
                "id" => 1,
                "title" => "War of the worlds",
                "description" => "description here",
                "author" => "Ashish Patel"
            ]);
        $data = json_decode($this->response->getContent(), true);
        $this->assertArrayHasKey('created_at', $data);
        $this->assertArrayHasKey('updated_at', $data);
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
        $this->notSeeInDatabase('books', ['title' => 'The Invisible Man']);

        $this->put('/books/1', [
            'id' => 5,
            'title' => 'The Invisible Man',
            'description' => 'description here',
            'author' => 'Ashish Patel'
        ]);

        $this->seeStatusCode(200)->seeJson([
            'id' => 1,
            'title' => 'The Invisible Man',
            'description' => 'description here',
            'author' => 'Ashish Patel'
        ])->seeInDatabase('books', ['title' => 'The Invisible Man']);
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
        $this->delete('/books/1')->seeStatusCode(204)->isEmpty();
        $this->notSeeInDatabase('books', ['id' => 1]);
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
