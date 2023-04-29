<?php
namespace MVC;
class Router{
    public $rutasGET = [];
    public $rutasPOST = [];
    public $rutasPUT = [];
    public $rutasDELETE = [];
    

    public function get($url, $fn){
        $this->rutasGET[$url] = $fn;
    }

    public function post($url, $fn){
        $this->rutasPOST[$url] = $fn;
    }

    public function put($url, $fn){
        $this->rutasPUT[$url] = $fn;
    }

    public function delete($url, $fn){
        $this->rutasDELETE[$url] = $fn;
    }


    public function comprobarRutas(){
        $auth = $_SESSION['login'] ?? null;
        
        $urlActual = $_SERVER['REDIRECT_URL'] ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];
        
        
        // Comprueba si el método es correcto
        if($metodo === 'GET'){
            $fn = $this->rutasGET[$urlActual] ?? null;
        }else if($metodo === 'POST'){
            $fn = $this->rutasPOST[$urlActual] ?? null;
        }else if($metodo === 'PUT'){
            $fn = $this->rutasPUT[$urlActual] ?? null;
        }else if($metodo === 'DELETE'){
            $fn = $this->rutasDELETE[$urlActual] ?? null;
        }else{
            $fn = false;
        }
        
        if(!$fn){
            echo "Página no encontrada";
        }else{
            // La url existe y hay una función asociada
            call_user_func($fn, $this);
        }
    }

    public function render($view, $datos = [] ) {
        foreach($datos as $key => $value){
            $$key = $value;
        }
        ob_start(); // Almacenamiento en memoria durante un momento...
        include __DIR__."/views/$view.php";

        $contenido = ob_get_clean(); // Limpia el Buffer

        include __DIR__."/views/layout.php";
    }
}