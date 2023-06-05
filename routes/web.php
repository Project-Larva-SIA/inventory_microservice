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

// Items routes

$router->get('/items','ItemsController@getItem');
$router->get('/items/{ItemID}','ItemsController@showItem');
$router->post('/items','ItemsController@addItem');
$router->put('/items/{ItemID}','ItemsController@updateItem');
$router->delete('/items/{ItemID}','ItemsController@deleteItem');

// Bids routes

$router->get('/bids','BidsController@getBids');
$router->get('/bids/{BidID}','BidsController@showBid');
$router->post('/bids','BidsController@addBid');
$router->put('/bids/{BidID}','BidsController@updateBid');
$router->delete('/bids/{BidID}','BidsController@deleteBid');