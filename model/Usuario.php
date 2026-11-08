<?php

class Usuario
{
    private $id;
    private $nombre;
    private $apellido;
    private $nombre_usuario;
    private $email;
    private $password;

    public function __construct($nombre, $apellido, $nombre_usuario,$email, $password){
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->nombre_usuario = $nombre_usuario;
        $this->email = $email;
        $this->password = $password;
    }

    public function getId(){
        return $this->id;
    }

    public function getNombre(){
        return $this->nombre;
    }
        public function getApellido(){
        return $this->apellido;
    }

    public function getEmail(){
        return $this->email;
    }

        public function getNombreUsuario(){
        return $this->nombre_usuario;
    }

        public function getPassword(){
        return $this->password;
    }

    
}