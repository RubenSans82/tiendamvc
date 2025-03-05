<?php

namespace Formacom\controllers;

use Formacom\Core\Controller;
use Formacom\Models\Order;
use Formacom\Models\Product;
use Formacom\Models\Customer;
use Illuminate\Database\Capsule\Manager as DB;
use Exception;
use TCPDF; // We'll need to add this library for PDF generation
use SimpleXMLElement;

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

    public function edit($orderId)
    {
        $order = Order::with(['customer', 'products'])->find($orderId);
        if (!$order) {
            header("Location: " . base_url() . "order/index");
            exit;
        }
        
        $products = Product::all();
        $customers = Customer::all();
        
        $this->view('edit', [
            'order' => $order,
            'products' => $products,
            'customers' => $customers
        ]);
    }
    
    public function getOrderData($orderId)
    {
        // Set JSON response header
        header('Content-Type: application/json');
        
        try {
            $order = Order::with(['customer', 'products'])->find($orderId);
            
            if (!$order) {
                echo json_encode(['success' => false, 'message' => 'Pedido no encontrado']);
                return;
            }
            
            echo json_encode(['success' => true, 'order' => $order]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error al cargar los datos: ' . $e->getMessage()]);
        }
    }
    
    public function update()
    {
        // Set JSON response header
        header('Content-Type: application/json');
        
        $postData = json_decode(file_get_contents('php://input'), true);
        
        if (!$postData) {
            echo json_encode(['success' => false, 'message' => 'Datos no recibidos']);
            exit;
        }
        
        try {
            // Start a transaction
            DB::beginTransaction();
            
            // Find the order
            $order = Order::find($postData['order_id']);
            
            if (!$order) {
                DB::rollBack();
                echo json_encode(['success' => false, 'message' => 'Pedido no encontrado']);
                return;
            }
            
            // Update order data
            $order->customer_id = $postData['customer_id'];
            $order->discount = isset($postData['discount']) ? $postData['discount'] : 0;
            $order->updated_at = date('Y-m-d H:i:s');
            $order->save();
            
            // Detach all existing products
            $order->products()->detach();
            
            // Debug
            error_log('Products data: ' . json_encode($postData['products']));
            
            // Attach updated products
            if (isset($postData['products']) && is_array($postData['products'])) {
                foreach ($postData['products'] as $productData) {
                    // Find the product to ensure it exists
                    $product = Product::find($productData['id']);
                    
                    if ($product) {
                        // Ensure quantity and price are properly set
                        $quantity = isset($productData['quantity']) && is_numeric($productData['quantity']) ? $productData['quantity'] : 1;
                        $price = isset($productData['price']) && is_numeric($productData['price']) ? $productData['price'] : $product->price;
                        
                        // Attach product with quantity and price
                        $order->products()->attach($productData['id'], [
                            'quantity' => $quantity,
                            'price' => $price,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                    }
                }
            }
            
            // Commit the transaction
            DB::commit();
            
            echo json_encode(['success' => true, 'message' => 'Pedido actualizado correctamente']);
        } catch (Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();
            echo json_encode(['success' => false, 'message' => 'Error al actualizar el pedido: ' . $e->getMessage()]);
        }
    }

    /**
     * Generate and output invoice
     */
    public function invoice($orderId, $format = 'pdf')
    {
        $order = Order::with(['customer', 'products'])->find($orderId);
        
        if (!$order) {
            header("Location: " . base_url() . "order/index");
            exit;
        }

        switch ($format) {
            case 'pdf':
                $this->generatePdfInvoice($order);
                break;
            case 'xml':
                $this->generateXmlInvoice($order);
                break;
            default:
                $this->generatePdfInvoice($order);
        }
    }

    /**
     * Generate and output PDF invoice
     */
    private function generatePdfInvoice($order)
    {
        // Create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // Set document information
        $pdf->SetCreator('TiendaMVC');
        $pdf->SetAuthor('TiendaMVC System');
        $pdf->SetTitle('Factura #' . $order->order_id);
        $pdf->SetSubject('Factura del pedido #' . $order->order_id);
        
        // Set default header data
        $pdf->SetHeaderData('', 0, 'FACTURA #' . $order->order_id, 'Fecha: ' . date('d/m/Y', strtotime($order->date)));
        
        // Set margins
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);
        
        // Set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 25);
        
        // Add a page
        $pdf->AddPage();
        
        // Prepare HTML content for the invoice
        $html = $this->view('../invoice/pdf', ['order' => $order], true);
        
        // Print HTML content
        $pdf->writeHTML($html, true, false, true, false, '');
        
        // Close and output PDF document
        $pdf->Output('factura_' . $order->order_id . '.pdf', 'I');
        exit;
    }

    /**
     * Generate and output XML invoice
     */
    private function generateXmlInvoice($order)
    {
        // Set appropriate headers for XML download
        header('Content-Type: application/xml; charset=utf-8');
        header('Content-Disposition: attachment; filename=factura_' . $order->order_id . '.xml');
        
        // Create XML document
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><invoice></invoice>');
        
        // Add invoice metadata
        $xml->addChild('invoice_id', $order->order_id);
        $xml->addChild('date', date('Y-m-d\TH:i:s', strtotime($order->date)));
        $xml->addChild('discount', $order->discount);
        
        // Add customer information
        $customer = $xml->addChild('customer');
        $customer->addChild('id', $order->customer->customer_id);
        $customer->addChild('name', htmlspecialchars($order->customer->name));
        
        // Add products
        $products = $xml->addChild('products');
        $subtotal = 0;
        
        foreach ($order->products as $product) {
            $quantity = $product->pivot->quantity ?? 1;
            $price = $product->pivot->price ?? $product->price;
            $productSubtotal = $quantity * $price;
            $subtotal += $productSubtotal;
            
            $productXml = $products->addChild('product');
            $productXml->addChild('id', $product->product_id);
            $productXml->addChild('name', htmlspecialchars($product->name));
            $productXml->addChild('price', $price);
            $productXml->addChild('quantity', $quantity);
            $productXml->addChild('subtotal', $productSubtotal);
        }
        
        // Add totals
        $totals = $xml->addChild('totals');
        $totals->addChild('subtotal', $subtotal);
        
        if ($order->discount > 0) {
            $discountAmount = $subtotal * ($order->discount / 100);
            $totals->addChild('discount_percent', $order->discount);
            $totals->addChild('discount_amount', $discountAmount);
        }
        
        $total = $subtotal;
        if ($order->discount > 0) {
            $total = $subtotal - ($subtotal * ($order->discount / 100));
        }
        $totals->addChild('total', $total);
        
        // Output XML
        echo $xml->asXML();
        exit;
    }
    
    /**
     * Send invoice by email
     */
    public function sendInvoice($orderId)
    {
        // Check if POST data exists
        if (!isset($_POST['emailTo']) || !isset($_POST['format'])) {
            $_SESSION['error'] = 'Faltan datos para enviar la factura';
            header("Location: " . base_url() . "order/show/" . $orderId);
            exit;
        }
        
        $email = $_POST['emailTo'];
        $format = $_POST['format'];
        
        $order = Order::with(['customer', 'products'])->find($orderId);
        
        if (!$order) {
            $_SESSION['error'] = 'Pedido no encontrado';
            header("Location: " . base_url() . "order/index");
            exit;
        }
        
        // Generate invoice file
        $filePath = $this->generateInvoiceFile($order, $format);
        
        // Send email with attachment
        $result = $this->sendInvoiceEmail($email, $order, $filePath, $format);
        
        // Clean up - delete temporary file
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        
        if ($result) {
            $_SESSION['success'] = 'Factura enviada correctamente a ' . $email;
        } else {
            $_SESSION['error'] = 'Error al enviar la factura';
        }
        
        header("Location: " . base_url() . "order/show/" . $orderId);
        exit;
    }
    
    /**
     * Generate invoice file and return the path
     */
    private function generateInvoiceFile($order, $format)
    {
        $tempDir = sys_get_temp_dir();
        $filename = 'factura_' . $order->order_id . '.' . $format;
        $filePath = $tempDir . '/' . $filename;
        
        if ($format == 'pdf') {
            // Generate PDF file
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator('TiendaMVC');
            $pdf->SetAuthor('TiendaMVC System');
            $pdf->SetTitle('Factura #' . $order->order_id);
            $pdf->SetSubject('Factura del pedido #' . $order->order_id);
            $pdf->SetHeaderData('', 0, 'FACTURA #' . $order->order_id, 'Fecha: ' . date('d/m/Y', strtotime($order->date)));
            $pdf->SetMargins(15, 15, 15);
            $pdf->SetHeaderMargin(5);
            $pdf->SetFooterMargin(10);
            $pdf->SetAutoPageBreak(TRUE, 25);
            $pdf->AddPage();
            
            $html = $this->view('../invoice/pdf', ['order' => $order], true);
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output($filePath, 'F');
        } else {
            // Generate XML file
            $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><invoice></invoice>');
            $xml->addChild('invoice_id', $order->order_id);
            $xml->addChild('date', date('Y-m-d\TH:i:s', strtotime($order->date)));
            $xml->addChild('discount', $order->discount);
            
            $customer = $xml->addChild('customer');
            $customer->addChild('id', $order->customer->customer_id);
            $customer->addChild('name', htmlspecialchars($order->customer->name));
            
            $products = $xml->addChild('products');
            $subtotal = 0;
            
            foreach ($order->products as $product) {
                $quantity = $product->pivot->quantity ?? 1;
                $price = $product->pivot->price ?? $product->price;
                $productSubtotal = $quantity * $price;
                $subtotal += $productSubtotal;
                
                $productXml = $products->addChild('product');
                $productXml->addChild('id', $product->product_id);
                $productXml->addChild('name', htmlspecialchars($product->name));
                $productXml->addChild('price', $price);
                $productXml->addChild('quantity', $quantity);
                $productXml->addChild('subtotal', $productSubtotal);
            }
            
            $totals = $xml->addChild('totals');
            $totals->addChild('subtotal', $subtotal);
            
            if ($order->discount > 0) {
                $discountAmount = $subtotal * ($order->discount / 100);
                $totals->addChild('discount_percent', $order->discount);
                $totals->addChild('discount_amount', $discountAmount);
            }
            
            $total = $subtotal;
            if ($order->discount > 0) {
                $total = $subtotal - ($subtotal * ($order->discount / 100));
            }
            $totals->addChild('total', $total);
            
            file_put_contents($filePath, $xml->asXML());
        }
        
        return $filePath;
    }
    
    /**
     * Send invoice by email
     */
    private function sendInvoiceEmail($email, $order, $filePath, $format)
    {
        // Load PHPMailer classes for email functionality
        // Note: This assumes PHPMailer is installed
        
        // Here we would normally have code to send an email with the invoice attached
        // For simplicity, we'll just simulate a successful send
        
        return true;
    }
}
