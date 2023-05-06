<?php

namespace Model;
use Intervention\Image\ImageManagerStatic as Image;

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
	private $nuevaImagen;
	private $imagenWebp;
	private $imagenPng;
    
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
		if(!$this->nuevaImagen) {
			self::$alertas['error'][] = 'La imagen es obligatoria';
		}
		if(!$this->tags) {
			self::$alertas['error'][] = 'El Campo áreas es obligatorio';
		}
	
		return self::$alertas;
	}

	public function setImagen(string $imageName) {
		if(!empty($imageName)) {
			$this->imagenPng = Image::make($imageName)->fit(800,800)->encode('png', 80);
			$this->imagenWebp = Image::make($imageName)->fit(800,800)->encode('webp', 80);
			// Nombre de la imagen
			$this->nuevaImagen = md5( uniqid( rand(), true ) );
		}
	}


	public function guardar() {
		$imageFile = '';
		if($this->nuevaImagen){
			$this->hayCarpetaImagenes();
			$this->removeOldImage();
			$this->imagen = $this->nuevaImagen;
			$imageFile = self::ABSOLUTE_IMAGE_FOLDER . $this->imagen;
			// Guardar las imágenes
			if(isset($this->imagenWebp)){
				$this->imagenWebp->save($imageFile . '.webp');
			}
			if(isset($this->imagenPng)){
				$this->imagenPng->save($imageFile . '.png');
			}
		}
		return parent::guardar();
	}

	private function hayCarpetaImagenes(){
		if(!is_dir(self::ABSOLUTE_IMAGE_FOLDER)){
			mkdir(self::ABSOLUTE_IMAGE_FOLDER, 0755, true);
		}
	}

	private function removeOldImage() {
		// Si no hay imagen antigua, no hacemos nada
		if(!$this->imagen) return;
		$image = self::ABSOLUTE_IMAGE_FOLDER . $this->imagen;
		if(file_exists($image .'.jpg')){
			unlink($image.'.jpg');
		}
		if(file_exists($image .'.webp')){
			unlink($image.'.webp');
		}
		if(file_exists($image .'.avif')){
			unlink($image.'.avif');
		}
		if(file_exists($image .'.png')){
			unlink($image.'.png');
		}
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