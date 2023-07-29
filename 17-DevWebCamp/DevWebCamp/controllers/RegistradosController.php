<?php

namespace Controllers;


use MVC\Router;
use Classes\Paginacion;
use Model\Paquete;
use Model\Registro;
use Model\Usuario;

class RegistradosController {
	public static function index(Router $router){
		solo_admin();
		$pagina_actual = filter_var($_GET['page'], FILTER_VALIDATE_INT);
		if(!$pagina_actual || $pagina_actual < 1){
			header('Location: /admin/registrados?page=1');
			die();
		}
		$registros_por_pagina = 10;
		$total = Registro::total();
		$paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);
		if($paginacion->total_paginas() < $pagina_actual) {
			header('Location: /admin/registrados?page=1');
			die();
		}
		$registrosTemp = Registro::get($registros_por_pagina, $paginacion->offset());
		$registros = [];
		foreach ($registrosTemp as $registroTemp) {
			$registro = $registroTemp->getStdClass();
			$registro->usuario = Usuario::find($registroTemp->usuario_id);
			$registro->paquete = Paquete::find($registroTemp->paquete_id);
			$registros[] = $registro;
		}
		
		$router->render('admin/registrados/index', [
			'titulo' => 'Usuarios Registrados',
			'registros' => $registros,
			'paginacion' => $paginacion->paginacion()
		]);
	}
}