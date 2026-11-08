<?php

require_once __DIR__ . "/generalException.php";

/** Se utiliza cuando la aplicación no puede establecer conexión con la BD. */
class NoConexionDataBaseException extends GeneralException
{
    public function __construct(
        string $message = "No se pudo conectar con la base de datos.",
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
