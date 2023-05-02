<?php
namespace Model\Database;


//require_once dirname(dirname(__DIR__))."/includes/config/Config.php";
class DB {
    protected static $db;
    private $query;
    private static $errors = [];
    /**
     * Id creado automáticamente. Se almacena aquí cuando se inserta un nuevo 
     * registro
     *
     * @var [int]
     */
    private static $id = null;

    public function __construct($query = null){
        self::hayDB();
        if(isset($query)){
            $this->query = $query;
        }else{
            $this->query = "";
        }
    }

    /**
     * Devuelve una instancia de la base de datos
     */
    public static function getDB(){
        self::hayDB();
        return self::$db;
    }

    /**
     * Devuelve una conexión a la base de datos
     */
    public static function conectarDB() {
        
        //self::$db = new \mysqli(\Config::DB_HOST, \Config::DB_USER, \Config::DB_PASSWORD, \Config::DB_NAME);
        self::$db = new \mysqli(
            $_ENV['DB_HOST'] ?? '',
            $_ENV['DB_USER'] ?? '', 
            $_ENV['DB_PASS'] ?? '', 
            $_ENV['DB_NAME'] ?? ''
        );
        if(self::$db->connect_errno) {
            self::$errors[] =  "Error ".self::$db->connect_errno.". No se pudo conectar: ".self::$db->connect_error;
            exit;
        }
        return self::$db;
    }

    /**
     * Realiza una operación de inserción en la base de datos
     */
    public static function insertOrUpdate($query){
        self::hayDB();
        $resultado = self::$db->query($query);
        
        if(!$resultado){
            self::$errors[] = "Error ".self::$db->errno.". No se pudo realizar la inserción: ".self::$db->error;
        }
        return $resultado;
    }

    public static function query($query){
        self::hayDB();
        $resultado = self::$db->query($query);
        if(self::$db->errno){
            self::$errors[] = "Error ".self::$db->errno.". No se pudo realizar la inserción: ".self::$db->error;
        }
        return $resultado;
    }

    /**
     * Devuelve el id de clave primaria del registro recién insertado
     *
     * @return int|null
     */
    public static function getId(){
        return self::$db->insert_id;
    }

    public static function getQueryObject($query){
        self::hayDB();
        $result = self::$db->query($query);
        $data = [];
        while($row = $result->fetch_object()){
            $data[] = $row;
        }
        // Liberar la memoria
        $result->free();
        return $data;
    }

    public static function getQueryArray($query){
        self::hayDB();
        $result = self::$db->query($query);
        $data = [];
        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        // Liberar la memoria
        $result->free();
        return $data;
    }

    public static function close(){
        if(isset(self::$db)){
            mysqli_close(self::$db);
        }
    }

    /**
	 * Comprueba si tenemos conexión a la base de datos, de lo contrario obtiene una
	 */
	private static function hayDB(){
		if(!isset(self::$db)){
			self::conectarDB();
		}
	}

    public static function table($table){
        $newDB = new self( "SELECT * FROM {$table}" );
        return $newDB;
    }

    /**
     * Devuelve el primer error ocurrido
     *
     * @return string
     */
    public static function getFirstError(){
        return array_shift( self::$errors );
    }

    /**
     * Devuelve el último error ocurrido
     *
     * @return string
     */
    public static function getLastError(){
        return end( self::$errors );
    }

    /**
     * Devuelve todos los errores ocurridos en el script
     *
     * @return array<string>
     */
    public static function getErrors(){
        return self::$errors;
    }

    public static function escape_string($value){
        self::hayDB();
        return self::$db->escape_string($value);
    }
}