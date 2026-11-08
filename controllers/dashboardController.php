<?php



require_once __DIR__ . "/../data/DAO/servis/DashboardService.php";

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../public/index.php?views=login");
    exit;
}

$usuarioId = (int) $_SESSION["usuario_id"];

$dashboardService = new DashboardService();


// ESTADÍSTICAS

$totalLibros = $dashboardService->contarLibros($usuarioId);

$librosLeidos = $dashboardService->contarLibrosLeidos($usuarioId);

$librosPendientes = $dashboardService->contarLibrosPendientes($usuarioId);

$librosLeyendo = $dashboardService->contarLibrosLeyendo($usuarioId);


// PROMEDIO

$promedioPuntuacion = $dashboardService->obtenerPromedioPuntuacion($usuarioId);

if ($promedioPuntuacion === null) {
    $promedioPuntuacion = "Todavía no hay puntuaciones.";
}


// ÚLTIMOS LIBROS AGREGADOS

$ultimosLibrosAgregados = $dashboardService->obtenerUltimosLibrosAgregados($usuarioId);

if (empty($ultimosLibrosAgregados)) {
    $mensajeUltimosAgregados = "Todavía no hay libros agregados.";
} else {
    $mensajeUltimosAgregados = null;
}


// ÚLTIMOS LIBROS LEÍDOS

$ultimosLibrosLeidos = $dashboardService->obtenerUltimosLibrosLeidos($usuarioId);

if (empty($ultimosLibrosLeidos)) {
    $mensajeUltimosLeidos = "Todavía no hay libros leídos.";
} else {
    $mensajeUltimosLeidos = null;
}


// GÉNEROS MÁS FRECUENTES

$generosMasFrecuentes = $dashboardService->obtenerGenerosMasFrecuentes($usuarioId);

if (empty($generosMasFrecuentes)) {
    $mensajeGeneros = "Todavía no hay géneros para mostrar.";
} else {
    $mensajeGeneros = null;
}


// TODOS LOS LIBROS

$todosLosLibros = $dashboardService->librosTotal($usuarioId);

if (empty($todosLosLibros)) {
    $mensajeGeneros = "Todavía no hay géneros para mostrar.";
} else {
    $mensajeGeneros = null;
}
require_once __DIR__ . "/../public/views/Dashboard.php";
