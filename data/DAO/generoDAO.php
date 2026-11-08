<?php

require_once __DIR__ . "/../../data/Conexion.php";
require_once __DIR__ . "/interfaces/GeneroDAOInterface.php";

class GeneroDAO implements GeneroDAOInterface
{
    private PDO $pdo;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->pdo = $conexion->conectar();
    }

    public function obtenerGeneros(): array
    {
        $sql = "SELECT id, nombre, descripcion
                FROM generos
                ORDER BY nombre";

        $consulta = $this->pdo->prepare($sql);
        $consulta->execute();

        return $consulta->fetchAll();
    }
}
