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
}
