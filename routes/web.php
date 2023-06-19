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

$router->get('/items','ItemsController@index');
$router->get('/items/{ItemID}','ItemsController@showItem');
$router->post('/items','ItemsController@addItem');
$router->delete('/items/{ItemID}','ItemsController@deleteItem');




// Bids routes

$router->get('/bids','BidsController@index');
$router->get('/bids/{BidID}','BidsController@showBid');
$router->delete('/bids/{BidID}','BidsController@deleteBid');

//  ITEM FEATURES

$router->get('/item/search/', 'FeaturesController@filter');
$router->get('/show/high', 'FeaturesController@HigherBid');


// BID FEATURES

$router->put('/bid/update/{BidID}','FeaturesController@updateBidAmount');
$router->post('/add/bid','FeaturesController@addBidAmount');
$router->get('/bid/info/{BidID}','FeaturesController@showHighBidItem');

