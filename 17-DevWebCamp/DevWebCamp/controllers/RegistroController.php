<?php

namespace Controllers;

use MVC\Router;
use Classes\Pass;
use Model\Evento;
use Model\EventosRegistros;
use Model\Paquete;
use Model\Regalo;
use Model\Usuario;
use Model\Registro;
use mysqli_sql_exception;

class RegistroController {
	public static function crear(Router $router){
		solo_auth();
		// Verificar si el usuario ya está registrado
		$registro = Registro::where('usuario_id', $_SESSION['id']);
		if(isset($registro) && $registro->paquete_id === Paquete::GRATIS) {
			header('Location: /boleto?id=' . urlencode($registro->token));
			exit;
		}

		if($registro->paquete_id === Paquete::PRESENCIAL) {
			header('Location: /finalizar-registro/conferencias');
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
		// Redireccionar a boleto virtual en caso de haber finalizado su registro
		if(isset($registro->regalo_id)) {
			header('Location: /boleto?id=' . urlencode($registro->token));
		}

		$regalos = Regalo::all('ASC');
		
		$router->render('registro/conferencias', [
			'titulo' => 'Elige Workshops y Conferencias',
			'eventos' => PaginasController::getEventosFormateados(),
			'regalos' => $regalos
		]);
	}

	public static function conferenciasPost(Router $router){
		solo_auth();

		// Validamos los eventos que nos vienen del cliente
		$eventos = explode(',', $_POST['eventos']);
		if(empty($eventos)) {
			Registro::setAlerta('error', 'No has seleccionado ningún evento, selecciona al menos uno');
			echo json_encode([
				'resultado' => false,
				'alertas' => Registro::getAlertas()
			]);
			return;
		}
		// Validamos el regalo
		$regalo_id = $_POST['regalo_id'] ?? '';
		if(empty($regalo_id)){
			Registro::setAlerta('error', 'No has seleccionado ningún regalo, selecciona uno');
			echo json_encode([
				'resultado' => false,
				'alertas' => Registro::getAlertas()
			]);
			return;
		}
		// Obtener el registro de usuario
		$registro = Registro::where('usuario_id', $_SESSION['id']);
		if(!isset($registro) || $registro->paquete_id !== Paquete::PRESENCIAL) {
			Registro::setAlerta('error', 'No estás correctamente registrado');
			echo json_encode([
				'resultado' => false,
				'alertas' => Registro::getAlertas()
			]);
			return;
		}
		// Iniciamos la transacción
		$transaction = Registro::begin_transaction();
		if(!$transaction){
			echo json_encode([
				'resultado' => $transaction,
				'alertas' => Registro::getAlertas()
			]);
			return;
		}
		try {
			foreach($eventos as $evento_id) {
				$evento = Evento::findForUpdate($evento_id);
				if(!isset($evento)) {
					throw new mysqli_sql_exception('Uno de los eventos solicitados tiene un id incorrecto');
				}
				if($evento->disponibles === "0") {
					throw new mysqli_sql_exception("El evento {$evento->nombre} no tiene plazas disponibles");
				}
				$evento->disponibles -= 1;
				$resultado = $evento->guardar();
				if(!$resultado['resultado']){
					Registro::setAlerta('error', $resultado['error']);
					throw new mysqli_sql_exception("El evento {$evento->nombre} no se ha podido actualizar");
				}
				// Almacenar el registro
				$datos = [
					'evento_id' => (int) $evento->id,
					'registro_id' => (int) $registro->id
				];
				$registro_usuario = new EventosRegistros($datos);
				$resultado = $registro_usuario->guardar();
				if(!$resultado['resultado']){
					Registro::setAlerta('error', $resultado['error']);
					throw new mysqli_sql_exception("La relación (Pase Presencial - {$evento->nombre}) no se ha podido crear");
				}
			}
			$registro->sincronizar(['regalo_id' => $regalo_id]);
			$resultado = $registro->guardar();
			if(!$resultado['resultado']){
				Registro::setAlerta('error', $resultado['error']);
				throw new mysqli_sql_exception("El registro de Pase Presencial no se ha podido actualizar");
			}
			// Si el código llega hasta aquí sin errores, guardamos todos los cambios en la base de datos
			Registro::commit();
		} catch (mysqli_sql_exception $exception) {
			Registro::rollback();
			Registro::setAlerta('error', $exception->getMessage());
			echo json_encode([
				'resultado' => false,
				'alertas' => Registro::getAlertas()
			]);
			return;
		}
		Registro::setAlerta('exito', "Se han guardado correctamente todos los eventos");
		echo json_encode([
			'resultado' => true,
			'alertas' => Registro::getAlertas(),
			'token' => $registro->token
		]);
	}
}