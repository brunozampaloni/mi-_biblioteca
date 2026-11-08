<?php

require_once __DIR__ . "/../../data/Conexion.php";
require_once __DIR__ . "/interfaces/DashboardDAOInterface.php";

class DashboardDAO implements DashboardDAOInterface
{
    private PDO $pdo;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->pdo = $conexion->conectar();
    }

    public function contarLibros(int $usuarioId): int
    {
        $sql = "SELECT COUNT(*) AS total
                FROM libros
                WHERE usuario_id = :usuario_id";

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            "usuario_id" => $usuarioId
        ]);

        return (int) $consulta->fetch()["total"];
    }


    
    public function librosTotal(int $usuarioId): array
    {
        $sql = "SELECT *
                FROM libros
                WHERE usuario_id = :usuario_id";

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            "usuario_id" => $usuarioId
        ]);

        return (array) $consulta->fetchall();
    }

    public function contarLibrosLeidos(int $usuarioId): int
    {
        $sql = "SELECT COUNT(*) AS total
                FROM libros
                WHERE usuario_id = :usuario_id
                AND estado_lectura = 'Leído'";

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            "usuario_id" => $usuarioId
        ]);

        return (int) $consulta->fetch()["total"];
    }


    public function contarLibrosPendientes(int $usuarioId): int
    {
        $sql = "SELECT COUNT(*) AS total
                FROM libros
                WHERE usuario_id = :usuario_id
                AND estado_lectura  = 'Pendiente'";

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            "usuario_id" => $usuarioId
        ]);

        return (int) $consulta->fetch()["total"];
    }


    public function contarLibrosLeyendo(int $usuarioId): int
    {
        $sql = "SELECT COUNT(*) AS total
                FROM libros
                WHERE usuario_id = :usuario_id
                AND estado_lectura  = 'Leyendo'";

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            "usuario_id" => $usuarioId
        ]);

        return (int) $consulta->fetch()["total"];
    }

        public function contarLibrosAbandonados(int $usuarioId): int
    {
        $sql = "SELECT COUNT(*) AS total
                FROM libros
                WHERE usuario_id = :usuario_id
                AND estado_lectura  = 'abandonado'";

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            "usuario_id" => $usuarioId
        ]);

        return (int) $consulta->fetch()["total"];
    }


    public function obtenerPromedioPuntuacion(int $usuarioId): ?float
    {
        $sql = "SELECT AVG(puntuacion) AS promedio
                FROM libros
                WHERE usuario_id = :usuario_id
                AND puntuacion IS NOT NULL";

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            "usuario_id" => $usuarioId
        ]);

        $resultado = $consulta->fetch();

        if ($resultado["promedio"] === null) {
            return null;
        }

        return (float) $resultado["promedio"];
    }


    public function obtenerUltimosLibrosAgregados(int $usuarioId): array{

        $sql = "SELECT *
                FROM libros
                WHERE usuario_id = :usuario_id
                ORDER BY id DESC
                LIMIT 3";

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            "usuario_id" => $usuarioId
        ]);

        return $consulta->fetchAll();
    }



    public function obtenerUltimosLibrosLeidos(int $usuarioId): array{

        $sql = "SELECT *
                FROM libros
                WHERE usuario_id = :usuario_id
                AND estado_lectura = 'Leído'
                ORDER BY id DESC
                LIMIT 3";

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            "usuario_id" => $usuarioId
        ]);

        return $consulta->fetchAll();
    }

    
    public function obtenerGenerosMasFrecuentes(int $usuarioId): array
    {
        $sql = "SELECT g.id, g.nombre, COUNT(l.id) AS cantidad
                FROM libros l
                INNER JOIN generos g ON l.genero_id = g.id
                WHERE l.usuario_id = :usuario_id
                GROUP BY g.id, g.nombre
                ORDER BY cantidad DESC
                LIMIT 3";

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            "usuario_id" => $usuarioId
        ]);

        return $consulta->fetchAll();
    }
}
