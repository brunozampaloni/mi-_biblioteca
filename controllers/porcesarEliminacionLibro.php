<?php

session_start();

require_once __DIR__ . "/../data/DAO/servis/LibroService.php";
require_once __DIR__ . "/historialController.php";
require_once __DIR__ . "/../exceptions/RecursoNoEncontradoException.php";
require_once __DIR__ . "/../exceptions/OperacionFallidaException.php";
require_once __DIR__ . "/../exceptions/ArchivoException.php";
require_once __DIR__ . "/../support/RegistroAplicacion.php";

$destino = "../public/index.php?views=dashboard";

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../public/index.php?views=loginRegistro/login");
    exit;
}

$usuarioId = (int) $_SESSION["usuario_id"];
$libroId = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

try {
    if ($libroId === false || $libroId === null || $libroId <= 0) {
        throw new RecursoNoEncontradoException("No se encontró el libro solicitado.");
    }

    $libroService = new LibroService();
    $libro = $libroService->obtenerPorId($libroId, $usuarioId);
    if ($libro === null) {
        throw new RecursoNoEncontradoException("El libro no existe o no pertenece a tu biblioteca.");
    }

    if (!$libroService->eliminar($libroId, $usuarioId)) {
        throw new OperacionFallidaException("No se pudo eliminar el libro.");
    }

    (new HistorialController())->registrar(
        $usuarioId,
        3,
        'Se borró el libro "' . $libro["titulo"] . '"'
    );

    (new RegistroAplicacion())->info(
        "libro.eliminacion_exitosa",
        "Se eliminó un libro de la biblioteca.",
        ["usuario_id" => $usuarioId, "libro_id" => $libroId]
    );

    if (!empty($libro["imagen"])) {
        $directorio = realpath(__DIR__ . "/../public/assets/imagenes/");
        $rutaImagen = realpath(__DIR__ . "/../public/" . ltrim($libro["imagen"], "/\\"));
        if ($directorio !== false && $rutaImagen !== false &&
            strpos($rutaImagen, $directorio . DIRECTORY_SEPARATOR) === 0 && is_file($rutaImagen)) {
            if (!unlink($rutaImagen)) {
                throw new ArchivoException("El libro se eliminó, pero no se pudo borrar su imagen.");
            }
        }
    }

    header("Location: " . $destino);
    exit;
} catch (GeneralException $e) {
    (new RegistroAplicacion())->warning(
        "libro.eliminacion_rechazada",
        $e->getMessage(),
        ["usuario_id" => $usuarioId, "libro_id" => (int) $libroId]
    );
    $_SESSION["flash_error"] = $e->getMessage();
    header("Location: " . $destino);
    exit;
} catch (Throwable $e) {
    (new RegistroAplicacion())->error(
        "libro.eliminacion_error",
        $e,
        ["usuario_id" => $usuarioId, "libro_id" => (int) $libroId]
    );
    $_SESSION["flash_error"] = "Ocurrió un error al eliminar el libro. Intentá nuevamente.";
    header("Location: " . $destino);
    exit;
}
