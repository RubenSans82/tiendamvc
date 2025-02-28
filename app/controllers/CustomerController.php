<?php

namespace Formacom\controllers;

use Formacom\Core\Controller;
use Formacom\Models\Customer;
use Formacom\Models\Address;
use Formacom\Models\Phone;
use Exception;

class CustomerController extends Controller
{
    public function index(...$params)
    {
        $customers = Customer::all();
        $this->view('home', $customers);
    }

    // New AJAX method to store customer data
    public function store(...$params)
    {
        // Check if this is an AJAX request (optional)
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        // Prepare response as JSON
        header('Content-Type: application/json');

        try {
            // Validate required fields
            if (empty($_POST['name'])) {
                throw new Exception('El nombre del cliente es requerido');
            }

            // Begin transaction (if your framework supports it)
            // Or manually commit/rollback in case of errors

            // Create and save customer
            $customer = new Customer();
            $customer->name = $_POST['name'];
            $customer->created_at = date('Y-m-d H:i:s');
            $customer->updated_at = date('Y-m-d H:i:s');
            $customer->save();

            // Create and save phone if provided
            if (!empty($_POST['number'])) {
                $phone = new Phone();
                $phone->number = $_POST['number'];
                $phone->customer_id = $customer->customer_id;
                $phone->created_at = date('Y-m-d H:i:s');
                $phone->updated_at = date('Y-m-d H:i:s');
                $phone->save();
            }

            // Create and save address if any address field provided
            if (!empty($_POST['street']) || !empty($_POST['city']) || 
                !empty($_POST['zip_code']) || !empty($_POST['country'])) {
                
                $address = new Address();
                $address->street = $_POST['street'] ?? '';
                $address->city = $_POST['city'] ?? '';
                $address->zip_code = !empty($_POST['zip_code']) ? intval($_POST['zip_code']) : 0;
                $address->country = $_POST['country'] ?? '';
                $address->customer_id = $customer->customer_id;
                $address->created_at = date('Y-m-d H:i:s');
                $address->updated_at = date('Y-m-d H:i:s');
                $address->save();
            }

            // Return success response
            echo json_encode([
                'success' => true,
                'message' => 'Cliente agregado correctamente',
                'customer_id' => $customer->customer_id
            ]);
        } catch (Exception $e) {
            // Return error response
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit; // Prevent further output
    }

    public function delete(...$params)
    {
        // Check if ID is provided
        if (!isset($params[0])) {
            echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
            exit;
        }

        $customer_id = $params[0];
        header('Content-Type: application/json');

        try {
            // Find customer
            $customer = Customer::find($customer_id);
            
            if (!$customer) {
                throw new Exception('Cliente no encontrado');
            }

            // Delete related phones
            foreach ($customer->phones as $phone) {
                $phone->delete();
            }

            // Delete related addresses
            foreach ($customer->addresses as $address) {
                $address->delete();
            }

            // Delete customer
            $customer->delete();

            // Return success response
            echo json_encode([
                'success' => true,
                'message' => 'Cliente eliminado correctamente'
            ]);
        } catch (Exception $e) {
            // Return error response
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit;
    }

    public function show(...$params)
    {
        if (isset($params[0])) {
            $customer = Customer::find($params[0]);
            if ($customer) {
                $this->view('detail', $customer);
                exit;
            }
        }
        header('Location: ' . base_url() . 'customer');
    }
    

    
    public function edit(...$params)
    {
        if (isset($params[0])) {
            $customer = Customer::find($params[0]);
            if ($customer) {
                // Manejar actualización de dirección
                if (isset($_POST['form_type']) && $_POST['form_type'] === 'address') {
                    $address_id = isset($_POST['address_id']) ? $_POST['address_id'] : null;
                    
                    if ($address_id) {
                        $address = Address::find($address_id);
                        if ($address) {
                            $address->street = $_POST['street'];
                            $address->city = $_POST['city'];
                            $address->zip_code = $_POST['zip_code'];
                            $address->country = $_POST['country'];
                            $address->save();
                        }
                    }
                    
                    header('Location: ' . base_url() . 'customer/edit/' . $customer->customer_id);
                    exit;
                }
                
                // Manejar actualización de teléfono
                if (isset($_POST['form_type']) && $_POST['form_type'] === 'phone') {
                    // Procesar el array de teléfonos
                    if (isset($_POST['phone']) && is_array($_POST['phone'])) {
                        foreach ($_POST['phone'] as $phone_id => $number) {
                            $phone = Phone::find($phone_id);
                            if ($phone) {
                                $phone->number = $number;
                                $phone->save();
                            }
                        }
                    }
                    
                    header('Location: ' . base_url() . 'customer/edit/' . $customer->customer_id);
                    exit;
                }
                
                // Manejar actualización del cliente (nombre)
                if (isset($_POST['form_type']) && $_POST['form_type'] === 'customer') {
                    $customer->name = $_POST['name'];
                    $customer->save();
                    
                    header('Location: ' . base_url() . 'customer/edit/' . $customer->customer_id);
                    exit;
                }
                
                $this->view('edit', $customer);
                exit;
            }
        }
        
        header('Location: ' . base_url() . 'customer');
    }
}
