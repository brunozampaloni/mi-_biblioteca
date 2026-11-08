<?php

class LibroModificacionDTO
{
    private $id;
    private $estadoDeLectura;
    private $puntuacionPersonal;
    private $resena;
    private $imagen;

    public function __construct(
        $id,
        $estadoDeLectura,
        $puntuacionPersonal,
        $resena,
        $imagen
    ) {
        $this->id = $id;
        $this->estadoDeLectura = $estadoDeLectura;
        $this->puntuacionPersonal = $puntuacionPersonal;
        $this->resena = $resena;
        $this->imagen = $imagen;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEstadoDeLectura()
    {
        return $this->estadoDeLectura;
    }

    public function getPuntuacionPersonal()
    {
        return $this->puntuacionPersonal;
    }

    public function getResena()
    {
        return $this->resena;
    }

    public function getImagen()
    {
        return $this->imagen;
    }
}