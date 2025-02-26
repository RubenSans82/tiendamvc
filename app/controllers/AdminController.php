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
        // Crear una nueva orden
        $order = new Order();
        $order->date = now();
        $order->discount = 20;
        $order->customer_id = 1; // Asume que el cliente con ID 1 existe
        $order->save();

        // Crear productos y asociarlos a la orden
        $product1 = Product::find(1); // Asume que el producto con ID 1 existe
        $product2 = Product::find(2); // Asume que el producto con ID 2 existe

        // Asociar productos a la orden
        $order->products()->attach([$product1->product_id, $product2->product_id]);

        // Verificar la relación
        $products = $order->products;
        foreach ($products as $product) {
            echo "Producto: " . $product->name . "<br>";
        }

        $data = ['mensaje' => '¡Relación muchos a muchos comprobada!'];
        $this->view('home', $data);
    }
}
?>
