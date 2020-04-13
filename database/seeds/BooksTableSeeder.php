<?php

class BooksTableSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        DB::table('books')->insert([
            'title' => 'War of the worlds',
            'description' => 'description here',
            'author' => 'Ashish Patel',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
        DB::table('books')->insert([
            'title' => 'A wrinkle in time',
            'description' => 'description here',
            'author' => 'Ashish Patel',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }
}
