<?php

namespace Controllers;

use Model\Dia;
use Model\Hora;
use MVC\Router;
use Model\Evento;
use Model\Ponente;
use Model\Categoria;

class PaginasController {
	public static function index(Router $router) {
		// Obtener el total de cada bloque
		$ponentes_total = Ponente::total();
		$conferencias_total = Evento::total('categoria_id', 1);
		$workshops_total = Evento::total('categoria_id', 2);
		$ponentes = Ponente::all();
		
		$router->render('paginas/index', [
			'titulo' => 'Inicio',
			'eventos' => self::getEventosFormateados(),
			'ponentes_total' => $ponentes_total,
			'conferencias_total' => $conferencias_total,
			'workshops_total' => $workshops_total,
			'ponentes' => $ponentes
		]);
	}

	public static function evento(Router $router) {

		$router->render('paginas/devwebcamp', [
			'titulo' => 'Sobre DevWebCamp'
		]);
	}

	public static function paquetes(Router $router) {

		$router->render('paginas/paquetes', [
			'titulo' => 'Paquetes DevWebCamp'
		]);
	}

	public static function conferencias(Router $router) {
		
		
		$router->render('paginas/conferencias', [
			'titulo' => 'Conferencias & Workshops',
			'eventos'  => self::getEventosFormateados()
		]);
	}

	private static function getEventosFormateados() {
		$eventos = Evento::ordenar('hora_id', 'ASC');

		$eventos_formateados = [];
		foreach ($eventos as $evento) {
			$object = $evento->getStdClass();
			$object->categoria = Categoria::find($evento->categoria_id);
			$object->dia = Dia::find($evento->dia_id);
			$object->hora = Hora::find($evento->hora_id);
			$object->ponente = Ponente::find($evento->ponente_id);
			if($evento->dia_id === "1" && $evento->categoria_id === "1") {
				$eventos_formateados['conferencias']['viernes'][] = $object;
			}
			if($evento->dia_id === "2" && $evento->categoria_id === "1") {
				$eventos_formateados['conferencias']['sabado'][] = $object;
			}
			if($evento->dia_id === "1" && $evento->categoria_id === "2") {
				$eventos_formateados['workshops']['viernes'][] = $object;
			}
			if($evento->dia_id === "2" && $evento->categoria_id === "2") {
				$eventos_formateados['workshops']['sabado'][] = $object;
			}
		}
		return $eventos_formateados;
	}
}