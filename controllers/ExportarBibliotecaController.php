<?php

session_start();

require_once __DIR__ . "/../data/DAO/servis/LibroService.php";
require_once __DIR__ . "/historialController.php";
require_once __DIR__ . "/../data/DAO/servis/ExportadorCSV.php";
require_once __DIR__ . "/../exceptions/ArchivoException.php";
require_once __DIR__ . "/../support/RegistroAplicacion.php";

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../public/index.php?views=loginRegistro/login");
    exit;
}

$ruta = null;

try {
    $usuarioId = (int) $_SESSION["usuario_id"];
    $libros = (new LibroService())->obtenerDatosParaCSV($usuarioId);
    $ruta = (new ExportadorCSV())->exportar($libros);

    (new HistorialController())->registrar(
        $usuarioId,
        6,
        "Exportó su biblioteca"
    );

    (new RegistroAplicacion())->info(
        "biblioteca.exportacion_exitosa",
        "Se exportó la biblioteca.",
        ["usuario_id" => $usuarioId, "cantidad_libros" => count($libros)]
    );

    header("Content-Type: text/csv; charset=utf-8");
    header('Content-Disposition: attachment; filename="biblioteca.csv"');
    header("Content-Length: " . filesize($ruta));
    readfile($ruta);
    unlink($ruta);
    exit;
} catch (ArchivoException $e) {
    if ($ruta !== null && is_file($ruta)) {
        unlink($ruta);
    }
    (new RegistroAplicacion())->warning("biblioteca.exportacion_fallida", $e->getMessage(), [
        "usuario_id" => (int) $_SESSION["usuario_id"]
    ]);
    $_SESSION["flash_error"] = $e->getMessage();
    header("Location: ../public/index.php?views=dashboard");
    exit;
} catch (Throwable $e) {
    if ($ruta !== null && is_file($ruta)) {
        unlink($ruta);
    }
    (new RegistroAplicacion())->error("biblioteca.exportacion_error", $e, [
        "usuario_id" => (int) $_SESSION["usuario_id"]
    ]);
    $_SESSION["flash_error"] = "No se pudo exportar la biblioteca. Intentá nuevamente.";
    header("Location: ../public/index.php?views=dashboard");
    exit;
}
