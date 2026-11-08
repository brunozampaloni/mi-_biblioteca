
<?php

require_once __DIR__ . "/../../model/Usuario.php";
require_once __DIR__ . "/../conexion.php";
require_once __DIR__ . "/interfaces/UsuarioDAOInterface.php";

class UsuarioDAO implements UsuarioDAOInterface
{
    private PDO $pdo;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->pdo = $conexion->conectar();
    }

    public function registrar(Usuario $usuario): bool
    {
        $sql = "INSERT INTO usuarios
                (nombre, apellido, nombre_usuario, email, password)
                VALUES
                (:nombre, :apellido, :nombre_usuario, :email, :password)";

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            "nombre" => $usuario->getNombre(),
            "apellido" => $usuario->getApellido(),
            "nombre_usuario" => $usuario->getNombreUsuario(),
            "email" => $usuario->getEmail(),
            "password" => $usuario->getPassword()
        ]);

        return $consulta->rowCount() > 0;
    }

    public function existeNombreUsuario(string $nombreUsuario): bool
    {
        $sql = "SELECT id FROM usuarios
                WHERE nombre_usuario = :nombre_usuario
                LIMIT 1";

        $consulta = $this->pdo->prepare($sql);
        $consulta->execute(["nombre_usuario" => $nombreUsuario]);

        return $consulta->fetch() !== false;
    }

    public function existeEmail(string $email): bool
    {
        $sql = "SELECT id FROM usuarios
                WHERE email = :email
                LIMIT 1";

        $consulta = $this->pdo->prepare($sql);
        $consulta->execute(["email" => $email]);

        return $consulta->fetch() !== false;
    }

    public function obtenerPorUsuarioOEmail(string $usuario): ?array
    {
        $sql = "SELECT id, nombre, apellido, nombre_usuario, email, password
                FROM usuarios
                WHERE email = :email
                   OR nombre_usuario = :nombre_usuario
                LIMIT 1";

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            "email" => $usuario,
            "nombre_usuario" => $usuario
        ]);

        $resultado = $consulta->fetch();

        return $resultado ?: null;
    }
}
