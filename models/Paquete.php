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
	 * Coste del Pase Presencial
	 */
	const FACE_TO_FACE_PASS = 199;
	/**
	 * Beneficio del Pase Presencial después de descontar comisiones bancarias
	 */
	const FACE_TO_FACE_PASS_REAL = 189.54;
	/**
	 * Pase Virtual
	 */
	const VIRTUAL_PASS = 49;
	/**
	 * Beneficio del Pase Virtual después de descontar comisiones bancarias
	 */
	const VIRTUAL_PASS_REAL = 46.41;
	
	protected static $tabla = 'paquetes';
    protected static $columnasDB = ['id', 'nombre'];

	public $nombre;
}