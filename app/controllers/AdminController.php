<?php

namespace Formacom\controllers;

use Formacom\Core\Controller;
use Formacom\Models\Customer;
use Formacom\Models\Provider;
use Formacom\Models\Order;
use Formacom\Models\Product;
use Illuminate\Database\Capsule\Manager as DB;
use function Symfony\Component\Clock\now;

class AdminController extends Controller
{
    public function index(...$params)
    {
        // Get counts using Eloquent models
        $customerCount = Customer::count();
        $providerCount = Provider::count();
        $productCount = Product::count();
        $orderCount = Order::count();
        
        $data = [
            'customerCount' => $customerCount,
            'providerCount' => $providerCount,
            'productCount' => $productCount,
            'orderCount' => $orderCount
        ];

        $this->view('home', $data);
    }
}
