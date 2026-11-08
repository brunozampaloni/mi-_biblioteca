<?php

session_start();

require_once __DIR__ . "/../model/DTO/LibroDTO.php";
require_once __DIR__ . "/../data/DAO/servis/LibroService.php";
require_once __DIR__ . "/historialController.php";
require_once __DIR__ . "/../exceptions/validacionException.php";
require_once __DIR__ . "/../exceptions/ArchivoException.php";
require_once __DIR__ . "/../exceptions/OperacionFallidaException.php";
require_once __DIR__ . "/../exceptions/RegistroDuplicadoException.php";
require_once __DIR__ . "/../support/RegistroAplicacion.php";

$destino = "../public/index.php?views=cargarLibros";
$rutaFisica = null;
$libroGuardado = false;

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new ValidacionException("La solicitud para agregar el libro no es válida.");
    }

    if (!isset($_SESSION["usuario_id"])) {
        header("Location: ../public/index.php?views=loginRegistro/login");
        exit;
    }

    $titulo = trim($_POST["titulo"] ?? "");
    $autor = trim($_POST["autor"] ?? "");
    $generoId = filter_input(INPUT_POST, "genero_id", FILTER_VALIDATE_INT);
    $anoPublicacion = filter_input(INPUT_POST, "anoDePublicacion", FILTER_VALIDATE_INT);
    $editorial = trim($_POST["editorial"] ?? "");

    if ($titulo === "" || $autor === "" || $editorial === "" || $generoId === false || $generoId === null || $anoPublicacion === false || $anoPublicacion === null) {
        throw new ValidacionException("Completá todos los campos del libro con datos válidos.");
    }

    if (!isset($_FILES["imagen"]) || $_FILES["imagen"]["error"] !== UPLOAD_ERR_OK) {
        throw new ArchivoException("No se pudo recibir la imagen del libro.");
    }

    $imagen = $_FILES["imagen"];
    $tipoImagen = mime_content_type($imagen["tmp_name"]);
    $tiposPermitidos = ["image/jpeg" => "jpg", "image/png" => "png", "image/webp" => "webp"];

    if (!isset($tiposPermitidos[$tipoImagen]) || getimagesize($imagen["tmp_name"]) === false) {
        throw new ArchivoException("El archivo debe ser una imagen JPG, PNG o WEBP válida.");
    }

    $directorio = __DIR__ . "/../public/assets/imagenes/";
    if (!is_dir($directorio) && !mkdir($directorio, 0755, true) && !is_dir($directorio)) {
        throw new ArchivoException("No se pudo preparar el almacenamiento de imágenes.");
    }

    $nombreImagen = bin2hex(random_bytes(16)) . "." . $tiposPermitidos[$tipoImagen];
    $rutaFisica = $directorio . $nombreImagen;
    $rutaBD = "assets/imagenes/" . $nombreImagen;

    if (!move_uploaded_file($imagen["tmp_name"], $rutaFisica)) {
        throw new ArchivoException("No se pudo guardar la imagen del libro.");
    }

    $libroDTO = new LibroDTO($titulo, $autor, (int) $generoId, (int) $anoPublicacion, $editorial, $rutaBD);
    $guardado = (new LibroService())->registrarLibro($libroDTO, (int) $_SESSION["usuario_id"]);
    $libroGuardado = $guardado;

    if (!$guardado) {
        @unlink($rutaFisica);
        throw new OperacionFallidaException("No se pudo agregar el libro.");
    }

    (new HistorialController())->registrar(
        (int) $_SESSION["usuario_id"],
        1,
        'Agregó el libro "' . $titulo . '"'
    );

    header("Location: ../public/index.php?views=dashboard");
    exit;
} catch (GeneralException $e) {
    if (!$libroGuardado && $rutaFisica !== null && is_file($rutaFisica)) {
        unlink($rutaFisica);
    }
    if (!($e instanceof ValidacionException) && !($e instanceof RegistroDuplicadoException)) {
        (new RegistroAplicacion())->warning(
            "libro.alta_rechazada",
            $e->getMessage(),
            ["usuario_id" => (int) ($_SESSION["usuario_id"] ?? 0)]
        );
    }
    $_SESSION["flash_error"] = $e->getMessage();
    header("Location: " . $destino);
    exit;
} catch (Throwable $e) {
    if (!$libroGuardado && $rutaFisica !== null && is_file($rutaFisica)) {
        unlink($rutaFisica);
    }
    (new RegistroAplicacion())->error(
        "libro.alta_error",
        $e,
        ["usuario_id" => (int) ($_SESSION["usuario_id"] ?? 0)]
    );
    $_SESSION["flash_error"] = "Ocurrió un error al agregar el libro. Intentá nuevamente.";
    header("Location: " . $destino);
    exit;
}
