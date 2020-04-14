<?php

class BundlesTableSeeder extends \Illuminate\Database\Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Bundle::class, 5)->create()->each(function ($bundle) {
            $booksCount = rand(2, 5);
            $bookIds = [];

            while($booksCount > 0) {
                $book = \App\Models\Book::whereNotIn('id', $bookIds)->orderByRaw("RAND()")->first();

                $bundle->books()->attach($book);
                $bookIds[] = $book->id;
                $booksCount--;
            }
        });
    }
}
