<?php

require_once __DIR__ . "/../busquedaDAO.php";
require_once __DIR__ . "/../interfaces/BusquedaDAOInterface.php";

/** Expone la búsqueda al controlador sin acoplarlo al DAO concreto. */
class BusquedaService
{
    private BusquedaDAOInterface $busquedaDAO;

    public function __construct(?BusquedaDAOInterface $busquedaDAO = null)
    {
        $this->busquedaDAO = $busquedaDAO ?? new BusquedaDAO();
    }

    public function buscarLibros(
        int $usuarioId,
        string $termino = "",
        int $generoId = 0,
        string $estado = "",
        int $puntuacion = 0
    ): array {
        return $this->busquedaDAO->buscarLibros(
            $usuarioId,
            $termino,
            $generoId,
            $estado,
            $puntuacion
        );
    }
}
