<?php

namespace Formacom\controllers;

use Formacom\Core\Controller;
use Formacom\Models\Order;
use Formacom\Models\Product;
use Formacom\Models\Category;
use Formacom\Models\Provider;
use function Symfony\Component\Clock\now;

class ProductController extends Controller
{
    public function index(...$params)
    {
        $this->view('home');
    }

    public function edit(...$params)
    {
        // Check if ID is provided
        if (!isset($params[0])) {
            header("Location: " . base_url() . "product/index");
            exit;
        }

        $productId = $params[0];
        
        // Get product with its relationships
        $product = Product::with(['category', 'provider'])->find($productId);
        
        if (!$product) {
            // Product not found, redirect to product list
            header("Location: " . base_url() . "product/index");
            exit;
        }

        // Get all categories and providers for the select dropdowns
        $categories = Category::all();
        $providers = Provider::all();
        
        // Pass data to the view - FIXED: Use the correct path 'product/edit'
        $this->view('edit', [
            'product' => $product,
            'categories' => $categories,
            'providers' => $providers
        ]);
    }

    public function update(...$params)
    {
        // Check if ID is provided
        if (!isset($params[0])) {
            $response = ['success' => false, 'message' => 'ID de producto no proporcionado'];
            echo json_encode($response);
            exit;
        }

        $productId = $params[0];
        $product = Product::find($productId);
        
        if (!$product) {
            $response = ['success' => false, 'message' => 'Producto no encontrado'];
            echo json_encode($response);
            exit;
        }

        // Get JSON data from request
        $postData = json_decode(file_get_contents('php://input'), true);
        
        if (!$postData) {
            $response = ['success' => false, 'message' => 'Datos no recibidos'];
            echo json_encode($response);
            exit;
        }

        // Update product properties
        $product->name = $postData['name'] ?? $product->name;
        $product->description = $postData['description'] ?? $product->description;
        $product->price = $postData['price'] ?? $product->price;
        $product->stock = $postData['stock'] ?? $product->stock;
        $product->category_id = $postData['category_id'] ?? $product->category_id;
        $product->provider_id = $postData['provider_id'] ?? $product->provider_id;
        $product->updated_at = now();
        
        try {
            $product->save();
            $response = ['success' => true, 'message' => 'Producto actualizado correctamente', 'product' => $product];
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => 'Error al actualizar el producto: ' . $e->getMessage()];
        }
        
        echo json_encode($response);
    }
}
