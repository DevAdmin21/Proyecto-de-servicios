<?php
class Conexion {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $host = "localhost";
        $db   = "estudio_tatuajes";
        $user = "root";
        $pass = "";
        $charset = "utf8mb4";
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode([
                "status" => 500,
                "title" => "Error de base de datos",
                "detail" => $e->getMessage()
            ]);
            exit;
        }
    }

    //obtener la instancia única
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Conexion();
        }
        return self::$instance;
    }

    //obtener el objeto PDO
    public function getConnection() {
        return $this->pdo;
    }

    //Evitar clonación del objeto
    private function __clone() {}
}

//Para usarlo en otros archivos:
//$pdo = Conexion::getInstance()->getConnection();
?>