<?php

class Genero
{
    private $id;
    private $nombre;
    private $descripcion;

    public function __construct($nombre, $descripcion)
    {
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }
}