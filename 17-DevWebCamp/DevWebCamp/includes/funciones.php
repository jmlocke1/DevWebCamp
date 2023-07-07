<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

function debuguearSinExit($variable)  {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
}

function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function pagina_actual($path) {
    return str_contains( $_SERVER['PATH_INFO'], $path) ? true : false;
}
function iniciar_sesion(){
    if(!isset($_SESSION)) {
        session_start();
    }
}

function is_auth() : bool {
    iniciar_sesion();
    return isset($_SESSION['nombre']) && !empty($_SESSION);
}

function is_admin() : bool {
    iniciar_sesion();
    return isset($_SESSION['admin']) && $_SESSION['admin'] === "1";
}

function solo_admin() {
    if(!is_admin()){
        header('Location: /login');
        die();
    }
}


function aos_animacion() : string {
    $efectos = ['fade-up', 'fade-down', 'fade-left', 'fade-right', 'flip-left', 'flip-right', 'zoom-in', 'zoom-in-up', 'zoom-in-down', 'zoom-out'];
    $efecto = array_rand($efectos, 1);
    return 'data-aos="'.$efectos[$efecto].'"';
}