<?php

session_start();

require_once __DIR__ . "/../model/DTO/LibroModificacionDTO.php";
require_once __DIR__ . "/../data/DAO/servis/LibroService.php";
require_once __DIR__ . "/historialController.php";
require_once __DIR__ . "/../exceptions/validacionException.php";
require_once __DIR__ . "/../exceptions/ArchivoException.php";
require_once __DIR__ . "/../exceptions/RecursoNoEncontradoException.php";
require_once __DIR__ . "/../exceptions/OperacionFallidaException.php";
require_once __DIR__ . "/../support/RegistroAplicacion.php";

$destino = "../public/index.php?views=dashboard";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $_SESSION["flash_error"] = "La solicitud de modificación no es válida.";
    header("Location: " . $destino);
    exit;
}

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../public/index.php?views=loginRegistro/login");
    exit;
}

$usuarioId = (int) $_SESSION["usuario_id"];
$libroId = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$campo = $_POST["campo"] ?? "";
$imagenNueva = null;
$actualizacionRealizada = false;

try {
    if ($libroId === false || $libroId === null || $libroId <= 0 || $campo === "") {
        throw new ValidacionException("Faltan datos válidos para modificar el libro.");
    }

    $libroService = new LibroService();
    $libro = $libroService->obtenerPorId((int) $libroId, $usuarioId);
    if ($libro === null) {
        throw new RecursoNoEncontradoException("El libro no existe o no pertenece a tu biblioteca.");
    }

    $titulo = $libro["titulo"];
    $historialId = null;
    $descripcionHistorial = "";
    $resultado = false;
    $directorioImagenes = __DIR__ . "/../public/assets/imagenes/";

    switch ($campo) {
        case "estado":
            $estado = $_POST["estado"] ?? "";
            $estadosPermitidos = ["Pendiente", "Leyendo", "Leído", "Abandonado"];
            if (!in_array($estado, $estadosPermitidos, true)) {
                throw new ValidacionException("El estado seleccionado no es válido.");
            }
            $dto = new LibroModificacionDTO((int) $libroId, $estado, null, null, null);
            $resultado = $libroService->modificarEstado($dto, $usuarioId);
            $historialId = 4;
            $descripcionHistorial = 'Se modificó el estado del libro "' . $titulo . '"';
            break;

        case "puntuacion":
            if ($libro["estado_lectura"] !== "Leído") {
                throw new ValidacionException("Solo puedes puntuar un libro que hayas leído.");
            }
            $puntuacion = filter_input(INPUT_POST, "puntuacion", FILTER_VALIDATE_INT);
            if ($puntuacion === false || $puntuacion === null || $puntuacion < 1 || $puntuacion > 5) {
                throw new ValidacionException("La puntuación debe ser un número entero entre 1 y 5.");
            }
            $dto = new LibroModificacionDTO((int) $libroId, null, $puntuacion, null, null);
            $resultado = $libroService->modificarPuntuacion($dto, $usuarioId);
            $historialId = 5;
            $descripcionHistorial = 'Se modificó la puntuación del libro "' . $titulo . '" a ' . $puntuacion;
            break;

        case "resena":
            $resena = trim($_POST["resena"] ?? "");
            if ($resena === "") {
                throw new ValidacionException("La reseña no puede estar vacía.");
            }
            if (function_exists("mb_strlen") ? mb_strlen($resena, "UTF-8") > 2000 : strlen($resena) > 2000) {
                throw new ValidacionException("La reseña es demasiado larga.");
            }
            $dto = new LibroModificacionDTO((int) $libroId, null, null, $resena, null);
            $resultado = $libroService->modificarResena($dto, $usuarioId);
            $historialId = 2;
            $descripcionHistorial = 'Se modificó la reseña del libro "' . $titulo . '"';
            break;

        case "imagen":
            if (!isset($_FILES["imagen"]) || $_FILES["imagen"]["error"] !== UPLOAD_ERR_OK) {
                throw new ArchivoException("No se pudo recibir una imagen válida.");
            }
            $imagen = $_FILES["imagen"];
            if ($imagen["size"] > 5 * 1024 * 1024) {
                throw new ArchivoException("La imagen no puede superar los 5 MB.");
            }
            $tipoImagen = mime_content_type($imagen["tmp_name"]);
            $tiposPermitidos = ["image/jpeg" => "jpg", "image/png" => "png", "image/webp" => "webp"];
            if (!isset($tiposPermitidos[$tipoImagen]) || getimagesize($imagen["tmp_name"]) === false) {
                throw new ArchivoException("El archivo debe ser una imagen JPG, PNG o WEBP válida.");
            }
            if (!is_dir($directorioImagenes) && !mkdir($directorioImagenes, 0755, true) && !is_dir($directorioImagenes)) {
                throw new ArchivoException("No se pudo preparar el almacenamiento de imágenes.");
            }
            $nombreImagen = bin2hex(random_bytes(16)) . "." . $tiposPermitidos[$tipoImagen];
            $imagenNueva = $directorioImagenes . $nombreImagen;
            if (!move_uploaded_file($imagen["tmp_name"], $imagenNueva)) {
                throw new ArchivoException("No se pudo guardar la nueva imagen.");
            }
            $rutaBD = "assets/imagenes/" . $nombreImagen;
            $dto = new LibroModificacionDTO((int) $libroId, null, null, null, $rutaBD);
            $resultado = $libroService->modificarImagen($dto, $usuarioId);
            if (!$resultado) {
                @unlink($imagenNueva);
                $imagenNueva = null;
                throw new OperacionFallidaException("No se pudo actualizar la imagen del libro.");
            }
            $actualizacionRealizada = true;
            $historialId = 2;
            $descripcionHistorial = 'Se modificó la imagen del libro "' . $titulo . '"';
            break;

        default:
            throw new ValidacionException("El tipo de modificación solicitado no es válido.");
    }

    if (!$resultado) {
        throw new OperacionFallidaException("No se pudo modificar el libro.");
    }

    (new HistorialController())->registrar($usuarioId, $historialId, $descripcionHistorial);

    (new RegistroAplicacion())->info(
        "libro.modificacion_exitosa",
        "Se modificó un libro de la biblioteca.",
        ["usuario_id" => $usuarioId, "libro_id" => (int) $libroId, "campo" => $campo]
    );

    if ($campo === "imagen" && !empty($libro["imagen"])) {
        $directorioReal = realpath($directorioImagenes);
        $rutaAnterior = realpath(__DIR__ . "/../public/" . ltrim($libro["imagen"], "/\\"));
        if ($directorioReal !== false && $rutaAnterior !== false &&
            strpos($rutaAnterior, $directorioReal . DIRECTORY_SEPARATOR) === 0 &&
            is_file($rutaAnterior) && $rutaAnterior !== realpath($imagenNueva)) {
            unlink($rutaAnterior);
        }
    }

    header("Location: ../public/index.php?views=dashboardLibro&id=" . (int) $libroId);
    exit;
} catch (GeneralException $e) {
    if (!$actualizacionRealizada && !empty($imagenNueva) && is_file($imagenNueva)) {
        @unlink($imagenNueva);
    }
    if (!($e instanceof ValidacionException)) {
        (new RegistroAplicacion())->warning(
            "libro.modificacion_rechazada",
            $e->getMessage(),
            ["usuario_id" => $usuarioId, "libro_id" => (int) $libroId]
        );
    }
    $_SESSION["flash_error"] = $e->getMessage();
    header("Location: ../public/index.php?views=dashboardLibro&id=" . max(0, (int) $libroId));
    exit;
} catch (Throwable $e) {
    if (!$actualizacionRealizada && !empty($imagenNueva) && is_file($imagenNueva)) {
        @unlink($imagenNueva);
    }
    (new RegistroAplicacion())->error(
        "libro.modificacion_error",
        $e,
        ["usuario_id" => $usuarioId, "libro_id" => (int) $libroId]
    );
    $_SESSION["flash_error"] = "Ocurrió un error al modificar el libro. Intentá nuevamente.";
    header("Location: ../public/index.php?views=dashboardLibro&id=" . max(0, (int) $libroId));
    exit;
}
