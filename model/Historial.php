<?php

class Historial
{
    private int $usuarioId;
    private string $operacion;
    private string $descripcion;

    public function __construct(
        int $usuarioId,
        string $operacion,
        string $descripcion
    ) {
        $this->usuarioId = $usuarioId;
        $this->operacion = $operacion;
        $this->descripcion = $descripcion;
    }

    public function getUsuarioId(): int
    {
        return $this->usuarioId;
    }

    public function getOperacion(): string
    {
        return $this->operacion;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }
}