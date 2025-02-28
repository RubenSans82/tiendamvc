<?php

namespace Formacom\controllers;

use Formacom\Core\Controller;
use Formacom\Models\Provider;
use Exception;

class ProviderController extends Controller
{
    public function index(...$params)
    {
        $providers = Provider::all();
        $this->view('home', $providers);
    }

    // New AJAX method to store provider data
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
                throw new Exception('El nombre del proveedor es requerido');
            }

            // Create and save provider
            $provider = new Provider();
            $provider->name = $_POST['name'];
            $provider->web = $_POST['web'] ?? '';
            $provider->phone = $_POST['phone'] ?? '';
            $provider->street = $_POST['street'] ?? '';
            $provider->city = $_POST['city'] ?? '';
            $provider->zip_code = $_POST['zip_code'] ?? '';
            $provider->country = $_POST['country'] ?? '';
            $provider->created_at = date('Y-m-d H:i:s');
            $provider->updated_at = date('Y-m-d H:i:s');
            $provider->save();

            // Return success response
            echo json_encode([
                'success' => true,
                'message' => 'Proveedor agregado correctamente',
                'provider_id' => $provider->provider_id
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

        $provider_id = $params[0];
        header('Content-Type: application/json');

        try {
            // Find provider
            $provider = Provider::find($provider_id);
            
            if (!$provider) {
                throw new Exception('Proveedor no encontrado');
            }

            // Delete provider
            $provider->delete();

            // Return success response
            echo json_encode([
                'success' => true,
                'message' => 'Proveedor eliminado correctamente'
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
            $provider = Provider::find($params[0]);
            if ($provider) {
                $this->view('detail', $provider);
                exit;
            }
        }
        header('Location: ' . base_url() . 'provider');
    }

    public function edit(...$params)
    {
        if (isset($params[0])) {
            $provider = Provider::find($params[0]);
            if ($provider) {
                if (isset($_POST['name'])) {
                    $provider->name = $_POST['name'];
                    $provider->save();
                    
                    header('Location: ' . base_url() . 'provider/edit/' . $provider->provider_id);
                    exit;
                }
                
                $this->view('edit', $provider);
                exit;
            }
        }
        
        header('Location: ' . base_url() . 'provider');
    }
}
