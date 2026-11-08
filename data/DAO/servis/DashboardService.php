<?php

require_once __DIR__ . "/../dashboardDAO.php";
require_once __DIR__ . "/../interfaces/DashboardDAOInterface.php";

/** Coordina el acceso a los datos que consume el panel principal. */
class DashboardService
{
    private DashboardDAOInterface $dashboardDAO;

    public function __construct(?DashboardDAOInterface $dashboardDAO = null)
    {
        $this->dashboardDAO = $dashboardDAO ?? new DashboardDAO();
    }

    public function contarLibros(int $usuarioId): int
    {
        return $this->dashboardDAO->contarLibros($usuarioId);
    }

    public function librosTotal(int $usuarioId): array
    {
        return $this->dashboardDAO->librosTotal($usuarioId);
    }

    public function contarLibrosLeidos(int $usuarioId): int
    {
        return $this->dashboardDAO->contarLibrosLeidos($usuarioId);
    }

    public function contarLibrosPendientes(int $usuarioId): int
    {
        return $this->dashboardDAO->contarLibrosPendientes($usuarioId);
    }

    public function contarLibrosLeyendo(int $usuarioId): int
    {
        return $this->dashboardDAO->contarLibrosLeyendo($usuarioId);
    }

    public function contarLibrosAbandonados(int $usuarioId): int
    {
        return $this->dashboardDAO->contarLibrosAbandonados($usuarioId);
    }

    public function obtenerPromedioPuntuacion(int $usuarioId): ?float
    {
        return $this->dashboardDAO->obtenerPromedioPuntuacion($usuarioId);
    }

    public function obtenerUltimosLibrosAgregados(int $usuarioId): array
    {
        return $this->dashboardDAO->obtenerUltimosLibrosAgregados($usuarioId);
    }

    public function obtenerUltimosLibrosLeidos(int $usuarioId): array
    {
        return $this->dashboardDAO->obtenerUltimosLibrosLeidos($usuarioId);
    }

    public function obtenerGenerosMasFrecuentes(int $usuarioId): array
    {
        return $this->dashboardDAO->obtenerGenerosMasFrecuentes($usuarioId);
    }
}
