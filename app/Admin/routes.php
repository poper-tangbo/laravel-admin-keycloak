<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {
    $router->get('/', 'HomeController@index')->name('home');
    $router->get('/test', 'TestController@test')->name('test');
    $router->get('/test1', 'TestController@test1')->name('test1');
    $router->get('/test2', 'TestController@test2')->name('test2');
});
