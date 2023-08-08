<?php

namespace Model;

class Paquete extends ActiveRecord {
	const PRESENCIAL = "1";
	const VIRTUAL = "2";
	const GRATIS = "3";

	/**
	 * Pase Gratuito
	 */
	const FREE_PASS = 0;
	/**
	 * Pase Presencial
	 */
	const FACE_TO_FACE_PASS = 199;
	/**
	 * Pase Virtual
	 */
	const VIRTUAL_PASS = 49;
	
	protected static $tabla = 'paquetes';
    protected static $columnasDB = ['id', 'nombre'];

	public $nombre;
}