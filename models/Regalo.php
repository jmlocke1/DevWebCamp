<?php

namespace Model;
use Intervention\Image\ImageManagerStatic as Image;

class Regalo extends ActiveRecord {
	protected static $tabla = 'regalos';
    protected static $columnasDB = ['id', 'nombre'];

    
    public $nombre;
    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
    }
}