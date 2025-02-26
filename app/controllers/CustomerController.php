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
                if (isset($_POST['name'])) {
                    $customer->name = $_POST['name'];
                    $customer->addresses[0]->street = $_POST['street'];
                    $customer->addresses[0]->city = $_POST['city'];
                    $customer->addresses[0]->zip_code = $_POST['zip_code'];
                    $customer->addresses[0]->country = $_POST['country'];
                    $customer->phones[0]->number = $_POST['number'];
                    $customer->save();
                    $customer->addresses[0]->save();
                    $customer->phones[0]->save();

                    header('Location: ' . base_url() . 'customer/index');
                    exit;
                }
                $this->view('edit', $customer);
                exit;
            }
        }
        header('Location: ' . base_url() . 'customer');
    }
}
