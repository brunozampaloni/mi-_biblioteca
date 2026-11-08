
<?php

require_once __DIR__ . "/../exceptions/noConexionDataBaseException.php";

class Conexion
{
    private string $servidor = "localhost";
    private string $usuario = "root";
    private string $pass = "";
    private string $dbname = "web_biblioteca";

    public function conectar(): PDO
    {
        $dsn = "mysql:host={$this->servidor};dbname={$this->dbname};charset=utf8mb4";

        $opciones = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        try {
            return new PDO(
                $dsn,
                $this->usuario,
                $this->pass,
                $opciones
            );
        } catch (PDOException $e) {
            throw new NoConexionDataBaseException(
                "No se pudo establecer conexión con la base de datos.",
                (int) $e->getCode(),
                $e
            );
        }
    }
}
