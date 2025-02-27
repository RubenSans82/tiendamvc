<?php

namespace Formacom\controllers;

use Formacom\Core\Controller;
use Formacom\Models\Order;
use Formacom\Models\Product;
use function Symfony\Component\Clock\now;

class AdminController extends Controller
{
    public function index(...$params)
    {

        $this->view('home');
    }
}
