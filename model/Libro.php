<?php

class Libro
{
    private $id;
    private $usuario_id;
    private $titulo;
    private $autor;
    private $genero_id;
    private $anoDePublicacion;
    private $editorial;
    private $estadoDeLectura;
    private $puntuacionPersonal;
    private $resena;
    private $imagen;
    private $pdf;

    public function __construct(
        $titulo,
        $autor,
        $genero_id,
        $anoDePublicacion,
        $editorial,
        $imagen,
        $pdf
    ) {
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->genero_id = $genero_id;
        $this->anoDePublicacion = $anoDePublicacion;
        $this->editorial = $editorial;
        $this->imagen = $imagen;
        $this->pdf = $pdf;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsuarioId()
    {
        return $this->usuario_id;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function getAutor()
    {
        return $this->autor;
    }

    public function getGeneroId()
    {
        return $this->genero_id;
    }

    public function getAnoDePublicacion()
    {
        return $this->anoDePublicacion;
    }

    public function getEditorial()
    {
        return $this->editorial;
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

            public function getPdf()
    {
        return $this->pdf;
    }
}