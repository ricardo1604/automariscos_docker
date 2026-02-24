<?php
class conectar
{
  
    private $servidor;
    private $usuario;
    private $bd;
    private $password;

    public function __construct() {
        // En Docker, el host se llama 'db', en local seria 'localhost'
        $this->servidor = getenv('DB_HOST') ?: "localhost";
        $this->usuario  = getenv('DB_USER') ?: "root";
        $this->password = getenv('DB_PASS') ?: "root";
        $this->bd       = getenv('DB_NAME') ?: "automariscos";
    }

    public function conexionMySQL()
    {
        $conexion=mysqli_connect($this->servidor,
									 $this->usuario,
									 $this->password,
                                     $this->bd) ;
									 if (!$conexion) {
										// Error log para ver en 'docker logs'
								            error_log("Error de conexión: " . mysqli_connect_error());
								            echo "Error de conexión a la base de datos.";
								            exit;
									}
									mysqli_set_charset($conexion,"utf8");				
			return $conexion;
        


    }
}
?>





