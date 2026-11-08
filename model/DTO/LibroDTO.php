<?php

class LibroDTO
{
    private $titulo;
    private $autor;
    private $genero_id;
    private $anoDePublicacion;
    private $editorial;
    private $imagen;
    private $pdf;

    public function __construct(
        $titulo,
        $autor,
        $genero_id,
        $anoDePublicacion,
        $editorial,
        $imagen
    ) {
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->genero_id = $genero_id;
        $this->anoDePublicacion = $anoDePublicacion;
        $this->editorial = $editorial;
        $this->imagen = $imagen;
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

    public function getImagen()
    {
        return $this->imagen;
    }



}