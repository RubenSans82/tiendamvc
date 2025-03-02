<?php

// ... existing routes

// Order routes
$app->route('order/index', 'OrderController@index');
$app->route('order/create', 'OrderController@create');
$app->route('order/store', 'OrderController@store');
$app->route('order/show/{id}', 'OrderController@show');
$app->route('order/delete/{id}', 'OrderController@delete'); // Ensure this route exists

// API routes
$app->route('api/orders', 'ApiController@getOrders');
$app->route('api/neworder', 'ApiController@newOrder');
$app->route('api/deleteorder/{id}', 'ApiController@deleteOrder'); // Consider adding this API route

// ... other routes
