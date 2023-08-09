<?php

namespace Controllers;

use Classes\Paginacion;
use MVC\Router;
use Model\Ponente;
use Intervention\Image\ImageManagerStatic as Image;

class PonentesController {
	public static function index(Router $router){
		solo_admin();
		$pagina_actual = filter_var($_GET['page'], FILTER_VALIDATE_INT);
		if(!$pagina_actual || $pagina_actual < 1){
			header('Location: /admin/ponentes?page=1');
			die();
		}
		$registros_por_pagina = 6;
		$total = Ponente::total();
		$paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);
		if($paginacion->total_paginas() < $pagina_actual) {
			header('Location: /admin/ponentes?page=1');
			die();
		}
		$ponentes = Ponente::get($registros_por_pagina, $paginacion->offset());
		$router->render('admin/ponentes/index', [
			'titulo' => 'Ponentes / Conferencistas',
			'ponentes' => $ponentes,
			'paginacion' => $paginacion->paginacion()
		]);
	}

	public static function crear(Router $router){
		solo_admin();
		$ponente = new Ponente();
		$router->render('admin/ponentes/crear', [
			'titulo' => 'Registrar Ponente',
			'alertas' => Ponente::getAlertas(),
			'ponente' => $ponente,
			'redes' => json_decode($ponente->redes)
		]);
	}

	public static function crearPost(Router $router){
		solo_admin();
		$ponente = new Ponente();
		$ponente_data = $_POST;
		
		$ponente_data['redes'] = json_encode($ponente_data['redes'], JSON_UNESCAPED_SLASHES);
		$ponente->sincronizar($ponente_data);
		$ponente->setImagen($_FILES['imagen']['tmp_name'] ?? '');
		
		$alertas = $ponente->validar();
		// Guardar el registro
		if(empty($alertas)){
			// Guardar en la BD
			$resultado = $ponente->guardar();
			if($resultado['resultado']){
				header('Location: /admin/ponentes');
				die();
			}
		}
		$router->render('admin/ponentes/crear', [
			'titulo' => 'Registrar Ponente',
			'alertas' => Ponente::getAlertas(),
			'ponente' => $ponente,
			'redes' => json_decode($ponente->redes)
		]);
	}

	public static function editar(Router $router){
		solo_admin();
		$ponente = self::getPonenteByGet();

		$router->render('admin/ponentes/editar', [
			'titulo' => 'Editar Ponente',
			'alertas' => Ponente::getAlertas(),
			'ponente' => $ponente,
			'mostrarImagen' => true,
			'redes' => json_decode($ponente->redes)
		]);
	}

	public static function editarPost(Router $router){
		solo_admin();
		$ponente = self::getPonenteByGet();
		
		$ponente_data = $_POST;
		
		$ponente_data['redes'] = json_encode($ponente_data['redes'], JSON_UNESCAPED_SLASHES);
		$ponente->sincronizar($ponente_data);
		$ponente->setImagen($_FILES['imagen']['tmp_name'] ?? '');
		
		$alertas = $ponente->validar();
		// Guardar el registro
		if(empty($alertas)){
			// Guardar en la BD
			$resultado = $ponente->guardar();
			if($resultado['resultado']){
				header('Location: /admin/ponentes');
				die();
			}
		}
		$router->render('admin/ponentes/editar', [
			'titulo' => 'Editar Ponente',
			'alertas' => Ponente::getAlertas(),
			'ponente' => $ponente,
			'mostrarImagen' => true,
			'redes' => json_decode($ponente->redes)
		]);
	}

	private static function getPonenteByGet(): Ponente {
		$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
		if(!$id){
			header('Location: /admin/ponentes');
			die();
		}
		$ponente = Ponente::find($id);
		if(!$ponente){
			header('Location: /admin/ponentes');
			die();
		}
		return $ponente;
	}

	public static function eliminar(){
		solo_admin();
		$id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
		if(!$id){
			header('Location: /admin/ponentes');
			die();
		}
		$ponente = Ponente::find($id);
		if($ponente){
			$ponente->eliminar();
		}
		header('Location: /admin/ponentes');
		die();
	}
}