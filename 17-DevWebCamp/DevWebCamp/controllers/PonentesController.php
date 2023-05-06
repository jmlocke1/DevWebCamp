<?php

namespace Controllers;

use MVC\Router;
use Model\Ponente;
use Intervention\Image\ImageManagerStatic as Image;

class PonentesController {
	public static function index(Router $router){
		$ponentes = Ponente::all();

		
		$router->render('admin/ponentes/index', [
			'titulo' => 'Ponentes / Conferencistas',
			'ponentes' => $ponentes
		]);
	}

	public static function crear(Router $router){
		$ponente = new Ponente();
		$router->render('admin/ponentes/crear', [
			'titulo' => 'Registrar Ponente',
			'alertas' => Ponente::getAlertas(),
			'ponente' => $ponente,
			'redes' => json_decode($ponente->redes)
		]);
	}

	public static function crearPost(Router $router){
		$ponente = new Ponente();
		$ponente_data = $_POST;
		// // Leer imagen
		// if(!empty($_FILES['imagen']['tmp_name'])) {
		// 	$carpeta_imagenes = '../public/build/img/speakers';
		// 	// Crear la carpeta si no existe
		// 	if(!is_dir($carpeta_imagenes)){
		// 		mkdir($carpeta_imagenes, 0755, true);
		// 	}
		// 	$imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png', 80);
		// 	$imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp', 80);

		// 	$nombre_imagen = md5( uniqid( rand(), true ) );
		// 	$ponente_data['imagen'] = $nombre_imagen;
		// }

		$ponente_data['redes'] = json_encode($ponente_data['redes'], JSON_UNESCAPED_SLASHES);
		$ponente->sincronizar($ponente_data);
		$ponente->setImagen($_FILES['imagen']['tmp_name'] ?? '');
		
		$alertas = $ponente->validar();
		// Guardar el registro
		if(empty($alertas)){
			// // Guardar las imágenes
			// $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . '.png');
			// $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . '.webp');
			// Guardar en la BD
			$resultado = $ponente->guardar();
			if($resultado){
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
		
		$router->render('admin/ponentes/editar', [
			'titulo' => 'Editar Ponente',
			'alertas' => Ponente::getAlertas(),
			'ponente' => $ponente,
			'mostrarImagen' => true,
			'redes' => json_decode($ponente->redes)
		]);
	}

	public static function editarPost(Router $router){

	}
}