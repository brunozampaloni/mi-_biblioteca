<?php

require_once __DIR__ . "/../../../model/DTO/historialDTO.php";

interface HistorialDAOInterface
{
    public function registrar(HistorialDTO $historial): bool;
    public function obtenerPorUsuario(int $usuarioId): array;
}
