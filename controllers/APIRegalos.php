<?php

namespace Controllers;

use Model\Paquete;
use Model\Regalo;
use Model\Registro;

class APIRegalos {
	public static function index(){
		if(!is_admin()) {
			echo json_encode([]);
			return;
		}
		$regalosTemp = Regalo::all();
		$regalos = [];
		foreach($regalosTemp as $regaloTemp) {
			$regalo = $regaloTemp->getStdClass();
			$regalo->total = Registro::totalArray([
				'regalo_id' => $regalo->id,
				'paquete_id' => Paquete::PRESENCIAL
			]);
			$regalos[] = $regalo;
		}

		echo json_encode($regalos);
		return;
	}
}