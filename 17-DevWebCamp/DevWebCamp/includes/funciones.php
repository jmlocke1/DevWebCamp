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