<?php

require_once __DIR__ . "/../UsuarioDAO.php";
require_once __DIR__ . "/../interfaces/UsuarioDAOInterface.php";
require_once __DIR__ . "/../../../model/Usuario.php";
require_once __DIR__ . "/../../../model/DTO/UsuarioRegistroDTO.php";
require_once __DIR__ . "/../../../model/DTO/UsuarioLoginDTO.php";
require_once __DIR__ . "/../../../exceptions/validacionException.php";
require_once __DIR__ . "/../../../exceptions/RegistroDuplicadoException.php";
require_once __DIR__ . "/../../../exceptions/OperacionFallidaException.php";
require_once __DIR__ . "/../../../traits/LoggableTrait.php";

class UsuarioService
{
    use LoggableTrait;

    private UsuarioDAOInterface $usuarioDAO;

    public function __construct(?UsuarioDAOInterface $usuarioDAO = null)
    {
        $this->usuarioDAO = $usuarioDAO ?? new UsuarioDAO();
    }

    public function registrarUsuario(UsuarioRegistroDTO $datos): void
    {
        if ($datos->getPassword() !== $datos->getConfirmacionPassword()) {
            throw new ValidacionException("Las contraseñas no coinciden.", "contrasenas");
        }

        if ($this->usuarioDAO->existeNombreUsuario($datos->getNombreUsuario())) {
            throw new RegistroDuplicadoException(
                "usuario",
                "El nombre de usuario ya está registrado."
            );
        }

        if ($this->usuarioDAO->existeEmail($datos->getEmail())) {
            throw new RegistroDuplicadoException(
                "email",
                "El correo electrónico ya está registrado."
            );
        }

        $passwordHash = password_hash($datos->getPassword(), PASSWORD_DEFAULT);

        $usuario = new Usuario(
            $datos->getNombre(),
            $datos->getApellido(),
            $datos->getNombreUsuario(),
            $datos->getEmail(),
            $passwordHash
        );

        if (!$this->usuarioDAO->registrar($usuario)) {
            throw new OperacionFallidaException("No se pudo registrar el usuario.");
        }

        $this->logInfo("usuario.registro_exitoso", "Se registró una cuenta de usuario.");
    }

    public function iniciarSesion(UsuarioLoginDTO $datos): ?array
    {
        $usuario = $this->usuarioDAO->obtenerPorUsuarioOEmail($datos->getUsuario());

        if ($usuario === null) {
            $this->logWarning("autenticacion.rechazada", "No se encontró una cuenta para el intento de inicio de sesión.");
            return null;
        }

        if (!password_verify($datos->getPassword(), $usuario["password"])) {
            $this->logWarning("autenticacion.rechazada", "La contraseña no coincide para el intento de inicio de sesión.");
            return null;
        }

        $this->logInfo(
            "autenticacion.exitosa",
            "Un usuario inició sesión.",
            ["usuario_id" => (int) $usuario["id"]]
        );
        return $usuario;
    }
}
