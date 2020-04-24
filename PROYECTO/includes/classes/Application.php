<?php
namespace es\ucm\fdi\aw;

/**
 * Clase que mantiene el estado global de la aplicación.
 */
class Application
{
	private static $instance;
	
	/**
	 * Permite obtener una instancia de <code>Aplicacion</code>.
	 * 
	 * @return Application Obtiene la única instancia de la <code>Aplicacion</code>
	 */
	public static function getSingleton() {
		if (  !self::$instance instanceof self) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * @var array Almacena los datos de configuración de la BD
	 */
	private $dbDataConnection;
	
	/**
	 * Almacena si la Aplicacion ya ha sido inicializada.
	 * 
	 * @var boolean
	 */
	private $initialized = false;
	
	/**
	 * @var \mysqli Conexión de BD.
	 */
	private $conn;
	
	/**
	 * Evita que se pueda instanciar la clase directamente.
	 */
	private function __construct() {
	}
	
	/**
	 * Evita que se pueda utilizar el operador clone.
	 */
	private function __clone()
	{
	    parent::__clone();
	}
	
	/**
	 * Evita que se pueda utilizar unserialize().
	 */
	private function __wakeup()
	{
	    return parent::__wakeup();
	}
	
	/**
	 * Inicializa la aplicación.
	 * 
	 * @param array $bdDatosConexion datos de configuración de la BD
	 */
	public function init($dbDataConnection)
	{
        if ( ! $this->initialized ) {
    	    $this->dbDataConnection = $dbDataConnection;
    		session_start();
    		$this->initialized = true;
        }
	}
	
	/**
	 * Cierre de la aplicación.
	 */
	public function shutdown()
	{
	    $this->checkInstanceInitialized();
	    if ($this->conn !== null) {
	        $this->conn->close();
	    }
	}
	
	/**
	 * Comprueba si la aplicación está inicializada. Si no lo está muestra un mensaje y termina la ejecución.
	 */
	private function checkInstanceInitialized()
	{
	    if (! $this->initialized ) {
	        echo "Aplicacion no inicializa";
	        exit();
	    }
	}
	
	/**
	 * Devuelve una conexión a la BD. Se encarga de que exista como mucho una conexión a la BD por petición.
	 * 
	 * @return \mysqli Conexión a MySQL.
	 */
	public function bdConnection()
	{
	    $this->checkInstanceInitialized();
		if (! $this->conn ) {
			$dbHost = $this->dbDataConnection['host'];
			$dbUser = $this->dbDataConnection['user'];
			$dbPass = $this->dbDataConnection['pass'];
			$db = $this->dbDataConnection['db'];
			
			$this->conn = new \mysqli($dbHost, $dbUser, $dbPass, $db);
			if ( $this->conn->connect_errno ) {
				echo "Error de conexión a la BD: (" . $this->conn->connect_errno . ") " . utf8_encode($this->conn->connect_error);
				exit();
			}
			if ( ! $this->conn->set_charset("utf8mb4")) {
				echo "Error al configurar la codificación de la BD: (" . $this->conn->errno . ") " . utf8_encode($this->conn->error);
				exit();
			}
		}
		return $this->conn;
	}
}