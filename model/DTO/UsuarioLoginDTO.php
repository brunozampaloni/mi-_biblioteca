
<?php

class UsuarioLoginDTO
{
    private string $usuario;
    private string $password;

    public function __construct(string $usuario, string $password)
    {
        $this->usuario = $usuario;
        $this->password = $password;
    }

    public function getUsuario(): string
    {
        return $this->usuario;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
