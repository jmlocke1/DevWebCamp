<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Categoria;
use Model\Dia;
use Model\Evento;
use Model\Hora;
use Model\Ponente;
use MVC\Router;
use stdClass;

class EventosController {
	public static function index(Router $router){
		$pagina_actual = filter_var($_GET['page'], FILTER_VALIDATE_INT);
		if(!$pagina_actual || $pagina_actual < 1) {
			header('Location: /admin/eventos?page=1');
		}

		$por_pagina = 10;
		$total = Evento::total();
		$paginacion = new Paginacion($pagina_actual, $por_pagina, $total);
		
		$eventos = Evento::get($por_pagina, $paginacion->offset());
		foreach ($eventos as $key => $evento) {
			$object = $evento->getStdClass();
			$object->categoria = Categoria::find($evento->categoria_id);
			$object->dia = Dia::find($evento->dia_id);
			$object->hora = Hora::find($evento->hora_id);
			$object->ponente = Ponente::find($evento->ponente_id);
			$eventos[$key] = $object;
		}
		
		$router->render('admin/eventos/index', [
			'titulo' => 'Conferencias y Workshops',
			'eventos' => $eventos,
			'paginacion' => $paginacion->paginacion()
		]);
	}

	public static function crear(Router $router) {
		$categorias = Categoria::all('ASC');
		$dias = Dia::all('ASC');
		$horas = Hora::all('ASC');
		$evento = new Evento();

		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			$evento->sincronizar($_POST);
			$alertas = $evento->validar();
			if(empty($alertas)){
				$resultado = $evento->guardar();
				if($resultado) {
					header('Location: /admin/eventos');
					die();
				}
			}
		}
		
		$router->render('admin/eventos/crear', [
			'titulo' => 'Registrar Evento',
			'categorias' => $categorias,
			'dias' => $dias,
			'horas' => $horas,
			'evento' => $evento,
			'alertas' => Categoria::getAlertas()
		]);
	}

	public static function editar(Router $router) {
		$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
		if(!$id) {
			header('Location: /admin/eventos');
			die();
		}
		$categorias = Categoria::all('ASC');
		$dias = Dia::all('ASC');
		$horas = Hora::all('ASC');
		$evento = Evento::find($id);
		if(!$evento) {
			header('Location: /admin/eventos');
			die();
		}
		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			$evento->sincronizar($_POST);
			$alertas = $evento->validar();
			if(empty($alertas)){
				$resultado = $evento->guardar();
				if($resultado) {
					header('Location: /admin/eventos');
					die();
				}
			}
		}
		
		$router->render('admin/eventos/editar', [
			'titulo' => 'Editar Evento',
			'categorias' => $categorias,
			'dias' => $dias,
			'horas' => $horas,
			'evento' => $evento,
			'alertas' => Categoria::getAlertas()
		]);
	}
}