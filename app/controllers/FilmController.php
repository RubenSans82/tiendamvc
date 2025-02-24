<?php
namespace Formacom\controllers;
use Formacom\Core\Controller;
use Formacom\Models\Film;

class FilmController extends Controller{
    public function index(...$params){
        $films=Film::all();
        $data = [
            'mensaje' => '¡Bienvenido a la página de Films!',
            'films'=>$films
        ];

        $this->view('film_list', $data);
    }
}
?>