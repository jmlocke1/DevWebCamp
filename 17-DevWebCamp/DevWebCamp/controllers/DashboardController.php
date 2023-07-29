<?php

namespace Controllers;

use Model\Registro;
use Model\Usuario;
use MVC\Router;

class DashboardController {
	public static function index(Router $router){
		solo_admin();
		// Obtener últimos registros
		$registrosTemp = Registro::get(5, null, 'DESC');
		$registros = [];
		foreach ($registrosTemp as $registroTemp) {
			$registro = $registroTemp->getStdClass();
			$registro->usuario = Usuario::find($registro->usuario_id);
			$registros[] = $registro;
		}
		$router->render('admin/dashboard/index', [
			'titulo' => 'Panel de Administración',
			'registros' => $registros
		]);
	}
}