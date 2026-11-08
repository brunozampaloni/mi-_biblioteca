<?php

class UsuarioRegistroDTO
{
    private string $nombre;
    private string $apellido;
    private string $nombreUsuario;
    private string $email;
    private string $password;
    private string $confirmacionPassword;

    public function __construct(
        string $nombre,
        string $apellido,
        string $nombreUsuario,
        string $email,
        string $password,
        string $confirmacionPassword
    ) {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->nombreUsuario = $nombreUsuario;
        $this->email = $email;
        $this->password = $password;
        $this->confirmacionPassword = $confirmacionPassword;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getApellido(): string
    {
        return $this->apellido;
    }

    public function getNombreUsuario(): string
    {
        return $this->nombreUsuario;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getConfirmacionPassword(): string
    {
        return $this->confirmacionPassword;
    }
}
