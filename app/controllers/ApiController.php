<?php

namespace Formacom\controllers;

use Formacom\Core\Controller;
use Formacom\Models\Category;
use Formacom\Models\Provider;
use Formacom\Models\Product;

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
    
    public function newproduct()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $product = new Product();
        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->stock = $data['stock'];
        $product->price = $data['price'];
        $product->category_id = $data['category_id'];
        $product->provider_id = $data['provider_id'];
        $product->save();
        
        // Usar la función de formateo para mantener consistencia
        $products = Product::all();
        $formattedProducts = $this->formatProducts($products);
        
        header('Content-Type: application/json');
        echo json_encode($formattedProducts);
        exit();
    }
    
    public function deleteproduct(...$params)
    {
        if (isset($params[0])) {
            $product = Product::find($params[0]);
            if ($product) {
                $product->delete();
            }
        }
        
        // Usar la función de formateo para mantener consistencia
        $products = Product::all();
        $formattedProducts = $this->formatProducts($products);
        
        header('Content-Type: application/json');
        echo json_encode($formattedProducts);
        exit();
    }

    public function products()
    {
        $products = Product::all();
        $formattedProducts = $this->formatProducts($products);
        
        header('Content-Type: application/json');
        echo json_encode($formattedProducts);
    }
    
    // Función auxiliar para formatear productos de manera consistente
    private function formatProducts($products)
    {
        $result = [];
        
        foreach ($products as $product) {
            $data = [
                'product_id' => $product->product_id,
                'name' => $product->name,
                'description' => $product->description,
                'stock' => $product->stock,
                'price' => $product->price,
                'category_id' => $product->category_id,
                'provider_id' => $product->provider_id
            ];
            
            // Obtener nombres de categoría y proveedor
            $category = Category::find($product->category_id);
            if ($category) {
                $data['category_name'] = $category->name;
            }
            
            $provider = Provider::find($product->provider_id);
            if ($provider) {
                $data['provider_name'] = $provider->name;
            }
            
            $result[] = $data;
        }
        
        return $result;
    }
}
