<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\User;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/login', 'AuthController@postLogin');

$router->get('/books', 'BookController@index');
$router->post('/books', 'BookController@store');
$router->get('/books/{id:[\d]+}', 'BookController@show');
$router->put('/books/{id:[\d]+}', 'BookController@update');
$router->delete('/books/{id:[\d]+}', 'BookController@destroy');

$router->group(['middleware' => 'auth'], function ($router) {
    $router->get('/users', function () use ($router) {
        return User::all();
    });

    $router->get('/posts', function () use ($router) {
        return response()->json([
            [
                'title' => 'new title'
            ],
            [
                'title' => 'another title'
            ]
        ]);
    });
});
