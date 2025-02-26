<?php

namespace Formacom\controllers;

use Formacom\Core\Controller;
use Formacom\Models\Category;
use Formacom\Models\Provider;


class ApiController extends Controller
{
    public function index(...$params) {}
    public function categories()
    {
        $categories = Category::all();
        header('Content-Type: application/json');
        echo json_encode($categories);
    }
    public function providers()
    {
        $providers = Provider::all();
        header('Content-Type: application/json');
        echo json_encode($providers);
    }
}
