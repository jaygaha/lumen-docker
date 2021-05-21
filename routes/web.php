<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['namespace' => 'V1', 'prefix' => 'api/v1'], function() use ($router)
{
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');

    //auth guard
    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->get('user/me', 'UserController@getProfile');
        $router->get('user/logout', 'UserController@logout');
        
        //Blog route
        $router->group(['prefix' => 'blog'], function() use ($router)
        {
            $router->get('categories', 'CategoryController@index');
            $router->post('categories/store', 'CategoryController@store');
            $router->put('categories/{id}','CategoryController@update');
            $router->get('categories/{id}','CategoryController@show');
            
            $router->get('/', 'PostController@index');
            $router->get('/{id}','PostController@show');
            $router->put('/{id}','PostController@update');
            $router->post('store', 'PostController@store');
            $router->delete('/{id}', 'PostController@destroy');
        });
    });
});