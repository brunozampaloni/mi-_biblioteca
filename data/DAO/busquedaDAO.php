
<?php

require_once __DIR__ . "/../Conexion.php";
require_once __DIR__ . "/interfaces/BusquedaDAOInterface.php";

class BusquedaDAO implements BusquedaDAOInterface
{
    private PDO $pdo;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->pdo = $conexion->conectar();
    }

    /**
     * Busca libros del usuario aplicando los filtros seleccionados.
     */
    public function buscarLibros(
        int $usuarioId,
        string $termino = "",
        int $generoId = 0,
        string $estado = "",
        int $puntuacion = 0
    ): array {
        $sql = "
            SELECT
                l.id,
                l.titulo,
                l.autor,
                l.genero_id,
                g.nombre AS genero,
                l.estado_lectura,
                l.puntuacion,
                l.imagen
            FROM libros AS l
            LEFT JOIN generos AS g
                ON l.genero_id = g.id
            WHERE l.usuario_id = :usuario_id
        ";

        $parametros = [
            ":usuario_id" => $usuarioId
        ];

        // Buscar por título o autor.
        if ($termino !== "") {
            $sql .= "
                AND (
                    l.titulo LIKE :titulo
                    OR l.autor LIKE :autor
                )
            ";

            $parametros[":titulo"] = "%" . $termino . "%";
            $parametros[":autor"] = "%" . $termino . "%";
        }

        // Filtrar por género.
        if ($generoId > 0) {
            $sql .= " AND l.genero_id = :genero_id";
            $parametros[":genero_id"] = $generoId;
        }

        // Filtrar por estado de lectura.
        if ($estado !== "") {
            $sql .= " AND l.estado_lectura = :estado";
            $parametros[":estado"] = $estado;
        }

        // Filtrar por puntuación exacta.
        if ($puntuacion >= 1 && $puntuacion <= 5) {
            $sql .= " AND l.puntuacion = :puntuacion";
            $parametros[":puntuacion"] = $puntuacion;
        }

        $sql .= " ORDER BY l.titulo ASC";

        $consulta = $this->pdo->prepare($sql);
        $consulta->execute($parametros);

        return $consulta->fetchAll();
    }
}
