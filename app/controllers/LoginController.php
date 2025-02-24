<?php
namespace Formacom\controllers;
use Formacom\Core\Controller;


class LoginController extends Controller{
    public function index(...$params){
        
        $this->view("login");
    }
    public function login(...$params){
        if(isset($_POST["first_name"])){
            var_dump($_POST);
            exit();
        }else{
            $this->view("new_actor"); 
        }
       
    }

    public function register(...$params){
        $this->view("register");
    }

    public function json(){
        $actores=Actor::where("first_name","like","P%")->get();
        $datos=[
            "mensaje"=>"Listado actores empiezan P",
            "listado"=>$actores
        ];
        $json=json_encode($datos);
        header('Content-Type: application/json');
        echo $json;
        exit();
    }

}
?>