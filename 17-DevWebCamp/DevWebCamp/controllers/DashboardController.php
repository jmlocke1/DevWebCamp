<?php

namespace Controllers;

use Model\Evento;
use Model\Paquete;
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

		// Calcular los ingresos
		$virtuales = Registro::total('paquete_id', Paquete::VIRTUAL);
		$presenciales = Registro::total('paquete_id', Paquete::PRESENCIAL);

		$ingresos = ($virtuales * Paquete::VIRTUAL_PASS_REAL) + ($presenciales * Paquete::FACE_TO_FACE_PASS_REAL);
		
		// Obtener eventos con más y menos lugares disponibles
		$menos_disponibles = Evento::ordenar('disponibles', 'ASC', 5);
		$mas_disponibles = Evento::ordenar('disponibles', 'DESC', 5);
		
		$router->render('admin/dashboard/index', [
			'titulo' => 'Panel de Administración',
			'registros' => $registros,
			'ingresos' => $ingresos,
			'menos_disponibles' => $menos_disponibles,
			'mas_disponibles' => $mas_disponibles
		]);
	}
}