<?php

namespace Model;

class Ponente extends ActiveRecord {
	protected static $tabla = 'ponentes';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'ciudad', 'pais', 'imagen', 'tags', 'redes'];
	const IMAGE_FOLDER = '/build/img/speakers/';
	const ABSOLUTE_IMAGE_FOLDER = DIR_ROOT . '/public' . self::IMAGE_FOLDER;
    public $id;
    public $nombre;
    public $apellido;
    public $ciudad;
    public $pais;
    public $password2;
    public $imagen;
    public $tags;
    public $redes;
    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->ciudad = $args['ciudad'] ?? '';
        $this->pais = $args['pais'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->tags = $args['tags'] ?? '';
        $this->redes = $args['redes'] ?? '';
    }

	public function validar() {
		if(!$this->nombre) {
			self::$alertas['error'][] = 'El Nombre es Obligatorio';
		}
		if(!$this->apellido) {
			self::$alertas['error'][] = 'El Apellido es Obligatorio';
		}
		if(!$this->ciudad) {
			self::$alertas['error'][] = 'El Campo Ciudad es Obligatorio';
		}
		if(!$this->pais) {
			self::$alertas['error'][] = 'El Campo País es Obligatorio';
		}
		if(!$this->imagen) {
			self::$alertas['error'][] = 'La imagen es obligatoria';
		}
		if(!$this->tags) {
			self::$alertas['error'][] = 'El Campo áreas es obligatorio';
		}
	
		return self::$alertas;
	}

	public function getImagenHTML(string $class = ''): string {
		// Si no hay imagen no devolvemos nada
		if(!$this->imagen) return '';

		if($class){
			$class = " class='$class'";
		}
		$avif = '';
		$webp = '';
		$png = '';
		if(file_exists(self::ABSOLUTE_IMAGE_FOLDER . $this->imagen . '.avif')){
			$avif = "<source srcset='". self::IMAGE_FOLDER . $this->imagen .".avif' type='image/avif'>";
		}
		if(file_exists(self::ABSOLUTE_IMAGE_FOLDER . $this->imagen . '.webp')){
			$webp = "<source srcset='". self::IMAGE_FOLDER . $this->imagen .".webp' type='image/webp'>";
		}
		if(file_exists(self::ABSOLUTE_IMAGE_FOLDER . $this->imagen . '.png')){
			$alt = "Imagen de {$this->nombre} {$this->apellido}";
			$png = "<img loading='lazy' src='". self::IMAGE_FOLDER . $this->imagen .".png' alt='$alt' title='$alt'>";
		}else{
			// Si no existe en png, no se devuelve nada
			return '';
		}
		$img = <<<PRE
	<picture$class>
		$avif
		$webp
		$png
	</picture>
PRE;
		return $img;
	}
}