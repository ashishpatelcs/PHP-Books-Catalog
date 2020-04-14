<?php

class BooksTableSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        factory(App\Models\Author::class, 10)->create()->each(function ($author) {
            $author->ratings()->saveMany(factory(App\Models\Rating::class, rand(20, 50))->make());

            $booksCount = rand(1, 6);

            while($booksCount > 0) {
                $book = factory(App\Models\Book::class)->make();
                $author->books()->save($book);
                $book->ratings()->saveMany(factory(App\Models\Rating::class, rand(20, 50))->make());
                $booksCount--;
            }
        });
    }
}
