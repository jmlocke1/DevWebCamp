<?php

namespace Model;

class Usuario extends ActiveRecord {
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'confirmado', 'token', 'admin'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $password2;
    public $confirmado;
    public $token;
    public $admin;
    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';
        $this->admin = $args['admin'] ?? '';
    }

    // Validar el Login de Usuarios
    public function validarLogin() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email del Usuario es Obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no válido';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password no puede ir vacio';
        }
        return self::$alertas;

    }

    // Validación para cuentas nuevas
    public function validar_cuenta() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if(!$this->apellido) {
            self::$alertas['error'][] = 'El Apellido es Obligatorio';
        }
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password no puede ir vacio';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
        }
        if($this->password !== $this->password2) {
            self::$alertas['error'][] = 'Los password son diferentes';
        }
        return self::$alertas;
    }

    // Valida un email
    public function validarEmail() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no válido';
        }
        return self::$alertas;
    }

    // Valida el Password 
    public function validarPassword() {
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password no puede ir vacio';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
        }
        return self::$alertas;
    }

    /**
	 * Función que permite cambiar el password, validando el nuevo password
	 *
	 * @param string $password_actual
	 * @param string $password_nuevo
	 * @return boolean
	 */
	public function nuevo_password(string $password_actual, string $password_nuevo): bool {
		if(!$password_actual){
			self::setAlerta('error', 'El Password Actual no puede ir vacío');
		}
		if(!$password_nuevo){
			self::setAlerta('error', 'El Password Nuevo no puede ir vacío');
		}
		if(strlen($password_nuevo) < 6) {
			self::$alertas['error'][] = 'El Password debe contener al menos 6 caracteres';
		}
		if($this->login($password_actual) && empty(self::$alertas)){
			return $this->hashPassword($password_nuevo);
		}else{
			return false;
		}
	}

    public function login(string $password): bool {
		$ok = password_verify($password, $this->password);
		if(!$ok){
			self::setAlerta('error', 'Password Incorrecto');
		}
		return $ok;
	}

    // // Comprobar el password
    // public function comprobar_password() : bool {
    //     return password_verify($this->password_actual, $this->password );
    // }

    public function hashPassword($nuevoPassword = null) {
		if(!$nuevoPassword) $nuevoPassword = $this->password;
		$password = password_hash($nuevoPassword, PASSWORD_DEFAULT);
		if($password){
			$this->password = $password;
			return true;
		}else{
			return false;
		}
	}

    // Generar un Token
    public function crearToken() : void {
        $this->token = uniqid();
    }
}