<?php

require_once __DIR__ . "/../../model/DTO/historialDTO.php";
require_once __DIR__ . "/../../data/Conexion.php";
require_once __DIR__ . "/interfaces/HistorialDAOInterface.php";

class HistorialDAO implements HistorialDAOInterface
{
    private PDO $pdo;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->pdo = $conexion->conectar();
    }

    public function registrar(HistorialDTO $historial): bool
    {
        $sql = "INSERT INTO historial
                (usuario_id, tipo_historial_id, descripcion)
                VALUES
                (:usuario_id, :tipo_historial_id, :descripcion)";

        $consulta = $this->pdo->prepare($sql);

        return $consulta->execute([
            "usuario_id" => $historial->getUsuarioId(),
            "tipo_historial_id" => $historial->getTipoHistorialId(),
            "descripcion" => $historial->getDescripcion()
        ]);
    }

    public function obtenerPorUsuario(int $usuarioId): array
    {
        $sql = "SELECT
                    h.id,
                    h.descripcion,
                    h.fecha_hora,
                    th.nombre AS tipo_historial
                FROM historial h
                INNER JOIN tipo_historial th
                    ON h.tipo_historial_id = th.id
                WHERE h.usuario_id = :usuario_id
                ORDER BY h.fecha_hora DESC";

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            "usuario_id" => $usuarioId
        ]);

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
}
