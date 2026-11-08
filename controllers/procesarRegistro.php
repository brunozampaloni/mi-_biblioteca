<?php

require_once __DIR__ . "/../data/DAO/servis/UsuarioService.php";
require_once __DIR__ . "/../model/DTO/UsuarioRegistroDTO.php";
require_once __DIR__ . "/../exceptions/validacionException.php";
require_once __DIR__ . "/../exceptions/RegistroDuplicadoException.php";
require_once __DIR__ . "/../support/RegistroAplicacion.php";

$destino = "../public/index.php?views=loginRegistro/registro";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: " . $destino);
    exit;
}

try {
$nombre = trim($_POST["nombre"] ?? "");
$apellido = trim($_POST["apellido"] ?? "");
$nombreUsuario = trim($_POST["nombre_usuario"] ?? "");
$email = strtolower(trim($_POST["email"] ?? ""));
$password = $_POST["password"] ?? "";
$confirmacionPassword = $_POST["confirmacion_password"] ?? "";

if ($nombre === "" || $apellido === "" || $nombreUsuario === "" || $email === "" || $password === "" || $confirmacionPassword === "") {
    throw new ValidacionException("Completá todos los campos.", "campos");
}

$longitudNombre = function_exists("mb_strlen") ? mb_strlen($nombre, "UTF-8") : strlen($nombre);
$longitudApellido = function_exists("mb_strlen") ? mb_strlen($apellido, "UTF-8") : strlen($apellido);

if ($longitudNombre > 100 || $longitudApellido > 100) {
    throw new ValidacionException("El nombre o apellido no es válido.", "nombre");
}

if (!preg_match('/^[a-zA-Z0-9_.-]{3,30}$/', $nombreUsuario)) {
    throw new ValidacionException("El nombre de usuario no es válido.", "usuario");
}

if (strlen($email) > 254 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    throw new ValidacionException("El correo electrónico no es válido.", "email");
}

$longitudPassword = function_exists("mb_strlen") ? mb_strlen($password, "UTF-8") : strlen($password);
if ($longitudPassword < 8) {
    throw new ValidacionException("La contraseña es demasiado corta.", "password");
}

if ($password !== $confirmacionPassword) {
    throw new ValidacionException("Las contraseñas no coinciden.", "contrasenas");
}

    $usuarioDTO = new UsuarioRegistroDTO(
        $nombre,
        $apellido,
        $nombreUsuario,
        $email,
        $password,
        $confirmacionPassword
    );

    $usuarioService = new UsuarioService();
    $usuarioService->registrarUsuario($usuarioDTO);
    header("Location: ../public/index.php?views=loginRegistro/login&registro=exitoso");
    exit;

} catch (RegistroDuplicadoException $e) {
    $error = $e->getCampo() === "usuario" ? "usuario_duplicado" : "email_duplicado";
    header("Location: " . $destino . "&error=" . $error);
    exit;
} catch (ValidacionException $e) {
    header("Location: " . $destino . "&error=" . urlencode($e->getCodigo()));
    exit;
} catch (Throwable $e) {
    (new RegistroAplicacion())->error("usuario.registro_error", $e);
    header("Location: " . $destino . "&error=registro");
    exit;
}
