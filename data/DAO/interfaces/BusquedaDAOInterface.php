<?php

interface BusquedaDAOInterface
{
    public function buscarLibros(
        int $usuarioId,
        string $termino = "",
        int $generoId = 0,
        string $estado = "",
        int $puntuacion = 0
    ): array;
}
