<?php

require_once __DIR__ . "/../generoDAO.php";
require_once __DIR__ . "/../interfaces/GeneroDAOInterface.php";

/** Expone el catálogo de géneros a los controladores y vistas. */
class GeneroService
{
    private GeneroDAOInterface $generoDAO;

    public function __construct(?GeneroDAOInterface $generoDAO = null)
    {
        $this->generoDAO = $generoDAO ?? new GeneroDAO();
    }

    public function obtenerGeneros(): array
    {
        return $this->generoDAO->obtenerGeneros();
    }
}
