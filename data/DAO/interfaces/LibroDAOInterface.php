<?php

require_once __DIR__ . "/../../../model/DTO/LibroDTO.php";
require_once __DIR__ . "/../../../model/DTO/LibroModificacionDTO.php";

interface LibroDAOInterface
{
    public function registrar(LibroDTO $libro, int $usuarioId): bool;
    public function modificarEstado(LibroModificacionDTO $libro, int $usuarioId): bool;
    public function modificarPuntuacion(LibroModificacionDTO $libro, int $usuarioId): bool;
    public function modificarResena(LibroModificacionDTO $libro, int $usuarioId): bool;
    public function modificarImagen(LibroModificacionDTO $libro, int $usuarioId): bool;
    public function obtenerPorTitulo(string $titulo): array;
    public function obtenerPorGenero(int $generoId): array;
    public function obtenerPorUsuario(int $usuarioId): array;
    public function obtenerPorId(int $id, int $usuarioId): ?array;
    public function obtenerDatosParaCSV(int $usuarioId): array;
    public function existeLibro(int $usuarioId, string $titulo, string $autor, int $generoId, int $anoDePublicacion): bool;
    public function eliminar(int $libroId, int $usuarioId): bool;
}
