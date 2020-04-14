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

use App\Models\User;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/login', 'AuthController@postLogin');

$router->group(['prefix' => '/books'], function ($router) {
    $router->get('/', 'BookController@index');
    $router->post('/', 'BookController@store');
    $router->get('/{id:[\d]+}', 'BookController@show');
    $router->put('/{id:[\d]+}', 'BookController@update');
    $router->delete('/{id:[\d]+}', 'BookController@destroy');
    $router->post('/{id:[\d]+}/ratings', 'BookController@addRating');
    $router->delete('/{id:[\d]+}/ratings/{ratingId:[\d]+}', 'BookController@removeRating');
});

$router->group(['prefix' => '/authors'], function ($router) {
    $router->get('/', 'AuthorController@index');
    $router->post('/', 'AuthorController@store');
    $router->get('/{id:[\d]+}', 'AuthorController@show');
    $router->put('/{id:[\d]+}', 'AuthorController@update');
    $router->delete('/{id:[\d]+}', 'AuthorController@destroy');
    $router->post('/{id:[\d]+}/ratings', 'AuthorController@addRating');
    $router->delete('/{id:[\d]+}/ratings/{ratingId:[\d]+}', 'AuthorController@removeRating');
});

$router->group(['prefix' => '/bundles'], function ($router) {
    $router->get('/', 'BundleController@index');
    $router->post('/', 'BundleController@store');
    $router->get('/{id:[\d]+}', 'BundleController@show');
    $router->put('/{id:[\d]+}', 'BundleController@update');
    $router->delete('/{id:[\d]+}', 'BundleController@destroy');
    $router->post('/{id:[\d]+}/ratings', 'BundleController@addRating');
    $router->delete('/{id:[\d]+}/ratings/{ratingId:[\d]+}', 'BundleController@removeRating');
    $router->put('/{id:[\d]+}/books/{bookId:[\d]+}', 'BundleController@addBook');
    $router->delete('/{id:[\d]+}/books/{bookId:[\d]+}', 'BundleController@removeBook');
});

$router->group(['middleware' => 'auth'], function ($router) {
    $router->get('/users', function () use ($router) {
        return User::all();
    });
});
