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