<?php

/**
 * Define your routes here
 * format: $routes[] = ['REQUEST_METHOD', 'URL', 'CONTROLLER', 'METHOD'];
 */

// Existing routes...

// Add these new routes for handling AJAX customer operations
$routes[] = ['POST', '/customer/store', 'CustomerController', 'store'];
$routes[] = ['POST', '/customer/delete/:id', 'CustomerController', 'delete'];

// Add these new routes for handling AJAX provider operations
$routes[] = ['POST', '/provider/store', 'ProviderController', 'store'];
$routes[] = ['POST', '/provider/delete/:id', 'ProviderController', 'delete'];

// Other existing routes...
