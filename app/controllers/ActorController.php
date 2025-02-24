<?php
namespace Formacom\controllers;
use Formacom\Core\Controller;
use Formacom\models\Actor;

class ActorController extends Controller{
    public function index(...$params){
        $actores=Actor::all();
        $this->view("actor_list",$actores);
        //echo "hola desde index de ActorController";
    }
    public function new(...$params){
        if(isset($_POST["first_name"])){
            var_dump($_POST);
            exit();
        }else{
            $this->view("new_actor"); 
        }
       
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