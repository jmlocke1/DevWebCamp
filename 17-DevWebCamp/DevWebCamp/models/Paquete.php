<?php

namespace Model;

class Paquete extends ActiveRecord {
	const PRESENCIAL = "1";
	const VIRTUAL = "2";
	const GRATIS = "3";
	
	protected static $tabla = 'paquetes';
    protected static $columnasDB = ['id', 'nombre'];

	public $nombre;
}