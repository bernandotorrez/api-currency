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
    return 'API Currency Created by Bernand';
});

$router->get('/currency', [
    'uses' => 'CurrencyController@getById'
]);

$router->get('/get/kurs', [
    'uses' => 'KursController@getById'
]);

$router->get('/get/kurs/count', [
    'uses' => 'KursController@countCall'
]);

$router->get('/get/kurs/all', [
    'uses' => 'KursController@getAll'
]);
