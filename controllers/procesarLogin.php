<?php

session_start();

require_once __DIR__ . "/../data/DAO/servis/UsuarioService.php";
require_once __DIR__ . "/../model/DTO/UsuarioLoginDTO.php";
require_once __DIR__ . "/../exceptions/validacionException.php";
require_once __DIR__ . "/../support/RegistroAplicacion.php";

$destino = "../public/index.php?views=loginRegistro/login";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: " . $destino);
    exit;
}

try {
    $usuario = trim($_POST["usuario"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($usuario === "" || $password === "") {
        throw new ValidacionException("Completá el usuario y la contraseña.", "campos");
    }

    $datosLogin = new UsuarioLoginDTO($usuario, $password);
    $usuarioService = new UsuarioService();
    $datosUsuario = $usuarioService->iniciarSesion($datosLogin);

    if ($datosUsuario === null) {
        header("Location: " . $destino . "&error=credenciales");
        exit;
    }

    session_regenerate_id(true);

    $_SESSION["usuario_id"] = $datosUsuario["id"];
    $_SESSION["usuario_nombre"] = $datosUsuario["nombre"];
    $_SESSION["usuario_apellido"] = $datosUsuario["apellido"];
    $_SESSION["usuario_username"] = $datosUsuario["nombre_usuario"];
    $_SESSION["usuario_email"] = $datosUsuario["email"];

    header("Location: ../public/index.php?views=dashboard");
    exit;
} catch (ValidacionException $e) {
    header("Location: " . $destino . "&error=" . urlencode($e->getCodigo()));
    exit;
} catch (Throwable $e) {
    (new RegistroAplicacion())->error("autenticacion.error", $e);
    header("Location: " . $destino . "&error=sistema");
    exit;
}
