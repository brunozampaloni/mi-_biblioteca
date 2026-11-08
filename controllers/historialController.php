<?php


require_once __DIR__ . '/../model/DTO/historialDTO.php';
require_once __DIR__ . '/../data/DAO/historialDAO.php';
require_once __DIR__ . '/../data/DAO/interfaces/HistorialDAOInterface.php';

class HistorialController
{
    private HistorialDAOInterface $historialDAO;

    public function __construct(?HistorialDAOInterface $historialDAO = null)
    {
        $this->historialDAO = $historialDAO ?? new HistorialDAO();
    }

    public function registrar(
        int $usuarioId,
        int $tipoHistorialId,
        string $descripcion
    ): bool {
        $historialDTO = new HistorialDTO(
            $usuarioId,
            $tipoHistorialId,
            $descripcion
        );

        return $this->historialDAO->registrar($historialDTO);
    }

    public function obtenerPorUsuario(int $usuarioId): array
    {
        return $this->historialDAO->obtenerPorUsuario($usuarioId);
    }
}
