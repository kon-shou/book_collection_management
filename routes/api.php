<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// TODO middleware('auth:api')
Route::prefix('user')->group(function ($route) {
    $route->post('/login', 'UserController@login');

    $route->get('/', 'UserController@index');
    $route->get('/{id}', 'UserController@show');
});

Route::prefix('book')->group(function ($route) {
    $route->post('/register', 'BookController@create');
});
