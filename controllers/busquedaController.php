
<?php

require_once __DIR__ . "/../data/DAO/servis/BusquedaService.php";
require_once __DIR__ . "/../data/DAO/servis/GeneroService.php";

// Comprobar que el usuario haya iniciado sesión.
if (!isset($_SESSION["usuario_id"])) {
    header("Location: index.php?views=loginRegistro/login");
    exit;
}

$usuarioId = (int) $_SESSION["usuario_id"];

// Obtener los datos del formulario.
$terminoBusqueda = trim($_GET["terminoBusqueda"] ?? "");
$generoId = filter_var(
    $_GET["genero_id"] ?? "0",
    FILTER_VALIDATE_INT
);

$generoId = ($generoId !== false && $generoId >= 0)
    ? $generoId
    : 0;

$estadoLectura = trim($_GET["estado_lectura"] ?? "");

$puntuacion = filter_var(
    $_GET["puntuacion"] ?? "0",
    FILTER_VALIDATE_INT
);

$puntuacion = (
    $puntuacion !== false &&
    $puntuacion >= 0 &&
    $puntuacion <= 5
) ? $puntuacion : 0;

// Estados permitidos en tu proyecto.
$estadosPermitidos = [
    "Pendiente",
    "Leyendo",
    "Leído",
    "Abandonado"
];

if (!in_array($estadoLectura, $estadosPermitidos, true)) {
    $estadoLectura = "";
}

// Obtener los géneros para el selector.
$generoService = new GeneroService();
$generos = $generoService->obtenerGeneros();

// Ejecutar la búsqueda.
$busquedaService = new BusquedaService();

$resultadosBusqueda = $busquedaService->buscarLibros(
    $usuarioId,
    $terminoBusqueda,
    $generoId,
    $estadoLectura,
    $puntuacion
);

// Cantidad de resultados.
$totalResultados = count($resultadosBusqueda);
