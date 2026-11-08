<?php

interface DashboardDAOInterface
{
    public function contarLibros(int $usuarioId): int;
    public function librosTotal(int $usuarioId): array;
    public function contarLibrosLeidos(int $usuarioId): int;
    public function contarLibrosPendientes(int $usuarioId): int;
    public function contarLibrosLeyendo(int $usuarioId): int;
    public function contarLibrosAbandonados(int $usuarioId): int;
    public function obtenerPromedioPuntuacion(int $usuarioId): ?float;
    public function obtenerUltimosLibrosAgregados(int $usuarioId): array;
    public function obtenerUltimosLibrosLeidos(int $usuarioId): array;
    public function obtenerGenerosMasFrecuentes(int $usuarioId): array;
}
