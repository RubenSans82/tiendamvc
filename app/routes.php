<?php

/**
 * Define your routes here
 * format: $routes[] = ['REQUEST_METHOD', 'URL', 'CONTROLLER', 'METHOD'];
 */

// Existing routes...

// Add these new routes for handling AJAX customer operations
$routes[] = ['POST', '/customer/store', 'CustomerController', 'store'];
$routes[] = ['POST', '/customer/delete/:id', 'CustomerController', 'delete'];

// Other existing routes...
