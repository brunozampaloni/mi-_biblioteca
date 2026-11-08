<?php

require_once __DIR__ . '/../data/DAO/servis/LibroService.php';

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../public/index.php?views=loginregistro/login");
    exit;
}

$usuarioId = (int) $_SESSION["usuario_id"];

if (!isset($_GET["id"])) {
    header("Location: ../public/index.php?views=dashboard");
    exit;
}

$libroId = (int) $_GET["id"];

$libroService = new LibroService();

$libro = $libroService->obtenerPorId($libroId, $usuarioId);

if ($libro === null) {
    header("Location: ../public/index.php?views=dashboardLibro");
    exit;
}

require_once __DIR__ . "/../public/views/dashboardLibro.php";
