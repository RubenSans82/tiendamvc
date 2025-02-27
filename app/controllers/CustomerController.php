<?php

namespace Formacom\controllers;

use Formacom\Core\Controller;
use Formacom\Models\Customer;
use Formacom\Models\Address;
use Formacom\Models\Phone;

class CustomerController extends Controller
{
    public function index(...$params)
    {
        $customers = Customer::all();



        $this->view('home', $customers);
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
    public function new(...$params)
    {
        if (isset($_POST['name'])) {
            $customer = new Customer();
            $address = new Address();
            $phone = new Phone();
            $customer->name = $_POST['name'];
            $address->street = $_POST['street'];
            $address->city = $_POST['city'];
            $address->zip_code = $_POST['zip_code'];
            $address->country = $_POST['country'];
            $phone->number = $_POST['number'];
            $customer->save();
            $customer->addresses()->save($address);
            $customer->phones()->save($phone);
            

            header('Location: ' . base_url() . 'customer/index');
            exit;
        }
        $this->view('new');
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
                    $phone_id = isset($_POST['phone_id']) ? $_POST['phone_id'] : null;
                    
                    if ($phone_id) {
                        $phone = Phone::find($phone_id);
                        if ($phone) {
                            $phone->number = $_POST['number'];
                            $phone->save();
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
