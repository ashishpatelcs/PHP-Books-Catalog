<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
    ];
});

$factory->define(\App\Models\Book::class, function (Faker $faker) {
    $title = $faker->sentence(rand(3, 10));

    return [
        'title' => substr($title, 0, strlen($title) - 1),
        'description' => $faker->text
    ];
});

$factory->define(\App\Models\Author::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'biography' => join(" ", $faker->sentences(rand(3, 5))),
        'gender' => rand(1, 6) % 2 === 0 ? 'male' : 'female'
    ];
});

$factory->define(\App\Models\Bundle::class, function (Faker $faker) {
    $title = $faker->sentence(rand(3, 10));

    return [
        'title' => substr($title, 0, strlen($title) - 1),
        'description' => $faker->text
    ];
});

$factory->define(\App\Models\Rating::class, function (Faker $faker) {
    return [ 'value' => rand(1, 5)];
});
