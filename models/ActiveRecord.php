<?php
namespace Model;
use Model\Database\DB;
use stdClass;

class ActiveRecord {

    /**
     * Identificador del modelo. Se declara aquí porque todos los modelos tienen un id, independientemente
     * de que sea un buen diseño o no
     *
     * @var [type]
     */
    public $id;
    // Base DE DATOS
    protected static $db = DB::class;
    protected static $tabla = '';
    protected static $columnasDB = [];
    protected static $where = '';

    /**
     * Variable que indica si el objeto es nuevo o no
     *
     * @var boolean
     */
    protected $newObject = false;

    // Alertas y Mensajes
    protected static $alertas = [];

    /**
	 * Clave o claves primarias. Si la clave primaria es diferente de 'id', hay que incluirla en
	 * este array en la clase hija. Si hay más de una clave primaria se añaden cuantos valores hagan
	 * falta
	 */
	protected static $primaryKeys = [];

    /**
	 * Claves foráneas de la aplicación. la clave asociativa es la clave foránea
	 * y el valor es la tabla:
	 * $foreignKeys[foreignkey] = tablename
	 */
	protected static $foreignKeys = [];

    /**
     * Claves primarias que son generadas automáticamente. Estas claves no 
     * se introducen cuando se crea un nuevo registro. El valor por defecto es
     * la clave 'id', si se establece otro u otros nombres como claves primarias
     * automáticas
     */
    protected static $automaticIds = ['id'];

    protected static function quitaIds(array $array){
        foreach(self::$automaticIds as $id){
            if(isset($array[$id])){
                unset($array[$id]);
            }
        }
        return $array;
    }
    
    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database) {
        self::$db = $database;
    }

    /**
     * Establece una alerta de un determinado tipo
     */
    public static function setAlerta($tipo, $mensaje) {
        static::$alertas[$tipo][] = $mensaje;
    }

    /**
     * Añade un array de alertas al array de alertas del objeto ActiveRecord
     */
    public static function addAlertasError(array $errores){
        foreach($errores as $error){
            self::setAlerta('error', $error);
        }
    }

    // Validación
    public static function getAlertas() {
        return static::$alertas;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function borrarAlertas(){
        static::$alertas = [];
    }

    public function validar() {
        static::$alertas = [];
        return static::$alertas;
    }

    // Consulta SQL para crear un objeto en Memoria
    public static function consultarSQL($query) {
        // Consultar la base de datos
        $resultado = self::$db::getQueryArray($query);
        // Iterar los resultados
        $array = [];
        foreach($resultado as $registro){
            $array[] = static::crearObjeto($registro);
        }
        // Obtener las alertas de la base de datos, si las hay
        $alertas = self::$db::getErrors();
        if(!empty($alertas)){
            self::addAlertasError($alertas);
        }
        // retornar los resultados
        return $array;
    }

    // Crea el objeto en memoria que es igual al de la BD
    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value ) {
            if(property_exists( $objeto, $key  )) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if(in_array($columna, static::$automaticIds)) continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    // Sanitizar los datos antes de guardarlos en la BD
    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value ) {
            if(is_null($value)){
                $sanitizado[$key] = $value;
            }else{
                $sanitizado[$key] = self::$db::escape_string($value);
            }
        }
        return $sanitizado;
    }

    // Sincroniza BD con Objetos en memoria
    public function sincronizar($args=[]) { 
        foreach($args as $key => $value) {
            if(property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Devuelve un objeto estándar con las propiedades de este objeto. Al ser un objeto estándar se le
     * pueden añadir nuevas propiedades dinámicamente sin problema
     *
     * @return stdClass
     */
    public function getStdClass(): stdClass {
        $object = new stdClass;

        foreach (static::$columnasDB as $column) {
            if(property_exists($this, $column)){
                $object->$column = $this->$column;
            }
        }
        return $object;
    }

    

    // Todos los registros
    public static function all($orden = 'DESC') {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id {$orden}";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca un registro por su id
    public static function find(array|int $id) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE id = {$id}";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    
    /**
     * Encuentra un registro mediante un select for update, bloqueando el registro
     * para su actualización
     *
     * @param array|integer $id Clave o claves primarias para encontrar el registro
     * @return static
     */
    public static function findForUpdate(array|int $id): static {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE id = {$id} FOR UPDATE";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    


    // Obtener Registros con cierta cantidad
    public static function get($limite, $offset = null, $order = 'ASC') {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id {$order} LIMIT {$limite}";
        if(!is_null($offset)){
            $query .= " OFFSET {$offset}";
        }
        
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca un registro por el valor de una columna
    public static function where($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE {$columna} = '{$valor}'";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    // Retornar los registros por un orden
    public static function ordenar($columna, $orden, $limite = 0): array {
        $query = "SELECT * FROM " . static::$tabla  ." ORDER BY {$columna} {$orden}";
        if($limite > 0) {
            $query .= " LIMIT {$limite}";
        }
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Retornar los registros por orden y con un límite
    // public static function ordenar($columna, $orden) {
    //     $query = "SELECT * FROM " . static::$tabla  ." ORDER BY {$columna} {$orden}";
    //     $resultado = self::consultarSQL($query);
    //     return $resultado;
    // }

    // Búsqueda Where con múltiples opciones
    public static function whereArray($array = []) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE";
        $and = '';
        foreach($array as $key => $value){
            $query .= $and . " {$key}='{$value}'";
            $and = " AND";
        }
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function total($columna = '', $valor = ''):int {
        $query = "SELECT COUNT(*) FROM " . static::$tabla;
        if($columna){
            $query .= " WHERE {$columna} = {$valor}";
        }
        $resultado = self::$db::query($query);
        $total = $resultado->fetch_array();
        return (int) array_shift($total);
    }

    public static function totalArray($array = []):int {
        $query = "SELECT COUNT(*) FROM " . static::$tabla . " WHERE ";
        $and = '';
        foreach($array as $key => $value){
            $query .= $and . " {$key}='{$value}'";
            $and = " AND";
        }
        $resultado = self::$db::query($query);
        $total = $resultado->fetch_array();
        return (int) array_shift($total);
    }

    // Busca un registro por el valor de una columna
    public static function belongsTo($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE {$columna} = '{$valor}'";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    /**
     * Consulta plana de SQL. Utilizar cuando los métodos del modelo 
     * no son suficientes
     *
     * @param [type] $columna
     * @param [type] $valor
     * @return void
     */
    public static function sql($query) {
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Registros - CRUD
    public function guardar() {
        $resultado = '';
        if(!is_null($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }

    // crea un nuevo registro
    public function crear() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES ('"; 
        $query .= join("', '", array_values($atributos));
        $query .= "') ";
        // Resultado de la consulta
        $resultado = self::$db::query($query);
        if($resultado){
            $respuesta = [
                'resultado' =>  $resultado,
                'id' => self::$db::getId()
             ];
        }else{
            $respuesta = [
                'resultado' => $resultado,
                "error" => self::$db::getLastError()
            ];
        }
        return $respuesta;
    }

    // Actualizar el registro
    public function actualizar() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        // Consulta SQL
        $query = "UPDATE " . static::$tabla ." SET ";
        $query .=  join(', ', $valores );
        $query .= " WHERE id = '" . self::$db::escape_string($this->id) . "' ";
        $query .= " LIMIT 1 "; 
        // Actualizar BD
        $resultado = self::$db::query($query);
        if($resultado) {
            $respuesta = [
                'resultado' => $resultado
            ];
        } else {
            $respuesta = [
                'resultado' => $resultado,
                "error" => self::$db::getLastError()
            ];
        }
        return $respuesta;
    }

    // Eliminar un Registro por su ID
    public function eliminar() {
        $query = "DELETE FROM "  . static::$tabla . " WHERE id = '" . self::$db::escape_string($this->id) . "' LIMIT 1";
        //$resultado = self::$db->query($query);
        $resultado = self::$db::query($query);

        return $resultado;
    }

    public static function begin_transaction(): bool {
        $ok = self::$db::begin_transaction();
        if(!$ok){
            self::setAlerta('error', self::$db::getLastError());
        }
        return $ok;
    }

    public static function commit(): bool {
        $ok = self::$db::commit();
        if(!$ok){
            self::setAlerta('error', self::$db::getLastError());
        }
        return $ok;
    }

    public static function rollback(): bool {
        $ok = self::$db::rollback();
        if(!$ok){
            self::setAlerta('error', self::$db::getLastError());
        }
        return $ok;
    }
}