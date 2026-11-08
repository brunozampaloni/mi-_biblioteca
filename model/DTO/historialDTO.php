<?php

class HistorialDTO
{
    private int $usuarioId;
    private int $tipoHistorialId;
    private string $descripcion;

    public function __construct(
        int $usuarioId,
        int $tipoHistorialId,
        string $descripcion
    ) {
        $this->usuarioId = $usuarioId;
        $this->tipoHistorialId = $tipoHistorialId;
        $this->descripcion = $descripcion;
    }

    public function getUsuarioId(): int
    {
        return $this->usuarioId;
    }

    public function getTipoHistorialId(): int
    {
        return $this->tipoHistorialId;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }
}