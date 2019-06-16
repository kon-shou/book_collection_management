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

Route::group(['prefix' => 'auth'], function ($route) {
    $route->post('/login', 'AuthController@login');
    $route->post('/register', 'AuthController@register');

    $route->group(['middleware' => ['auth:api']], function ($route) {
        $route->post('/logout', 'AuthController@logout');
        $route->get('/user', 'AuthController@user');
    });
});

Route::group(['prefix' => 'user'], function ($route) {
    $route->group(['middleware' => ['auth:api']], function ($route) {
        $route->get('/{id}', 'UserController@show');
    });
});

Route::group(['prefix' => 'book'], function ($route) {
    $route->group(['middleware' => ['auth:api']], function ($route) {
        $route->post('/register', 'BookController@create');
    });
});

