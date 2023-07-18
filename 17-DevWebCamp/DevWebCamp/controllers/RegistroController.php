<?php

namespace Controllers;

use MVC\Router;
use Classes\Pass;
use Model\Paquete;
use Model\Usuario;
use Model\Registro;

class RegistroController {
	public static function crear(Router $router){
		solo_auth();
		// Verificar si el usuario ya está registrado
		$registro = Registro::where('usuario_id', $_SESSION['id']);
		if(isset($registro) && $registro->paquete_id === Paquete::GRATIS) {
			header('Location: /boleto?id=' . urlencode($registro->token));
			exit;
		}
		
		$router->render('registro/crear', [
			'titulo' => 'Finalizar Registro',
			'pass' => Pass::class
		]);
	}

	public static function gratis(Router $router){
		solo_auth();
		$token = substr(md5(uniqid( rand(), true)), 0, 8);

		// Verificar si el usuario ya está registrado
		$registro = Registro::where('usuario_id', $_SESSION['id']);
		if(isset($registro) && $registro->paquete_id === Paquete::GRATIS) {
			header('Location: /boleto?id=' . urlencode($registro->token));
			exit;
		}
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
			header('Location: /');
			return;
		}

		// Buscarlo en la BD
		$registro = Registro::where('token', $id)->getStdClass();
		$registro->usuario = Usuario::find($registro->usuario_id);
		$registro->paquete = Paquete::find($registro->paquete_id);
		
		if(!$registro){
			header('Location: /');
		}

		$router->render('registro/boleto', [
			'titulo' => 'Asistencia a DevWebCamp',
			'pass' => Pass::class,
			'registro' => $registro
		]);
	}

	public static function pagar(Router $router){
		solo_auth();
		// Validar que Post no venga vacío
		if(empty($_POST)) {
			echo json_encode([]);
			return;
		}

		// Crear registro
		$datos = $_POST;
		$datos['token'] = substr(md5(uniqid( rand(), true)), 0, 8);
		$datos['usuario_id'] = $_SESSION['id'];
		
		try {
			$registro = new Registro($datos);
			$resultado = $registro->guardar();
			echo json_encode($resultado);
		} catch (\Throwable $th) {
			echo json_encode($resultado);
		}
	}

	public static function conferencias(Router $router){
		solo_auth();

		// Validar que el usuario tenga el plan presencial
		$registro = Registro::where('usuario_id', $_SESSION['id']);
		if(!$registro || $registro->paquete_id !== Paquete::PRESENCIAL){
			header('Location: /');
			return;
		}
		
		$router->render('registro/conferencias', [
			'titulo' => 'Elige Workshops y Conferencias',
			'eventos' => PaginasController::getEventosFormateados()
		]);
	}
}