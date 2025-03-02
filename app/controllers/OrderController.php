<?php

namespace Formacom\controllers;

use Formacom\Core\Controller;
use Formacom\Models\Order;
use Formacom\Models\Product;
use Formacom\Models\Customer;
use Illuminate\Database\Capsule\Manager as DB;
use Exception;

class OrderController extends Controller
{
    public function index(...$params)
    {
        $customers = Customer::all();
        $products = Product::all();
        $orders = Order::with(['customer', 'products'])->get();
        $this->view('home', [
            'customers' => $customers,
            'products' => $products,
            'orders' => $orders
        ]);
    }

    public function create()
    {
        $products = Product::all();
        $customers = Customer::all();
        $this->view('create', [
            'products' => $products,
            'customers' => $customers
        ]);
    }

    public function store()
    {
        $postData = json_decode(file_get_contents('php://input'), true);

        if (!$postData) {
            $response = ['success' => false, 'message' => 'Datos no recibidos'];
            echo json_encode($response);
            exit;
        }

        try {
            // Start a transaction to ensure data integrity
            DB::beginTransaction();
            
            // Create a new order
            $order = new Order();
            $order->customer_id = $postData['customer_id'];
            $order->discount = isset($postData['discount']) ? $postData['discount'] : 0;
            $order->date = date('Y-m-d H:i:s');
            $order->created_at = date('Y-m-d H:i:s');
            $order->updated_at = date('Y-m-d H:i:s');
            $order->save();
            
            // Add products to the order
            if (isset($postData['products']) && is_array($postData['products'])) {
                foreach ($postData['products'] as $productData) {
                    // Find the product to get the real price
                    $product = Product::find($productData['id']);
                    
                    if ($product) {
                        // Use provided price if exists, otherwise use product's price
                        $price = isset($productData['price']) ? $productData['price'] : $product->price;
                        
                        // Attach product to order with quantity and price
                        $order->products()->attach($productData['id'], [
                            'quantity' => $productData['quantity'],
                            'price' => $price,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                    }
                }
            }
            
            // Commit the transaction
            DB::commit();
            
            $response = ['success' => true, 'message' => 'Pedido creado correctamente', 'order' => $order];
            echo json_encode($response);
        } catch (Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();
            
            $response = ['success' => false, 'message' => 'Error al crear el pedido: ' . $e->getMessage()];
            echo json_encode($response);
        }
    }

    
    public function show($orderId)
    {
        $order = Order::with(['customer', 'products'])->find($orderId);
        if (!$order) {
            header("Location: " . base_url() . "order/index");
            exit;
        }
        $this->view('detail', ['order' => $order]);
    }
    
    public function delete($orderId)
    {
        // Set JSON response header
        header('Content-Type: application/json');
        
        try {
            // Find the order
            $order = Order::find($orderId);
            
            if (!$order) {
                echo json_encode(['success' => false, 'message' => 'Pedido no encontrado']);
                return;
            }
            
            // Start a transaction to ensure data integrity
            DB::beginTransaction();
            
            // The order_has_product relationship has CASCADE DELETE, 
            // but we'll explicitly detach the products to be safe
            $order->products()->detach();
            
            // Delete the order
            $order->delete();
            
            // Commit the transaction
            DB::commit();
            
            echo json_encode(['success' => true, 'message' => 'Pedido eliminado correctamente']);
        } catch (Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();
            echo json_encode(['success' => false, 'message' => 'Error al eliminar el pedido: ' . $e->getMessage()]);
        }
    }
}
