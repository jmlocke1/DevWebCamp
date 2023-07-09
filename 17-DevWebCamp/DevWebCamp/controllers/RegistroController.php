<?php

namespace Controllers;

use MVC\Router;
use Classes\Pass;
use Model\Registro;

class RegistroController {
	public static function crear(Router $router){
		solo_auth();
		$router->render('registro/crear', [
			'titulo' => 'Finalizar Registro',
			'pass' => Pass::class
		]);
	}

	public static function gratis(Router $router){
		solo_auth();
		$token = substr(md5(uniqid( rand(), true)), 0, 8);

		// Crear registro
		$datos = array(
			'paquete_id' => 3,
			'pago_id' => '',
			'token' => $token,
			'usuario_id' => $_SESSION['id']
		);
		$registro = new Registro($datos);
		$resultado = $registro->guardar();
		if($resultado['resultado']){
			header('Location: /boleto?id=' . urlencode($registro->token));
		}
	}

	public static function boleto(Router $router){
		solo_auth();
		// Validar la URL
		$id = $_GET['id'];
		
		if(!$id || !strlen($id) === 8){
			debuguear("Token no válido");
		}
		$router->render('registro/boleto', [
			'titulo' => 'Asistencia a DevWebCamp',
			'pass' => Pass::class
		]);
	}
}