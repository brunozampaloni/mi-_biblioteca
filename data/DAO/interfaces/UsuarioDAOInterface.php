<?php

require_once __DIR__ . "/../../../model/Usuario.php";

interface UsuarioDAOInterface
{
    public function registrar(Usuario $usuario): bool;
    public function existeNombreUsuario(string $nombreUsuario): bool;
    public function existeEmail(string $email): bool;
    public function obtenerPorUsuarioOEmail(string $usuario): ?array;
}
