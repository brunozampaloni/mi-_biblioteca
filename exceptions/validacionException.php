<?php
require_once __DIR__ . "/generalException.php";

/** Se utiliza cuando los datos recibidos no cumplen las reglas del sistema. */
class ValidacionException extends GeneralException
{
    private string $codigo;

    public function __construct(
        string $message,
        string $codigo = "validacion",
        ?Throwable $previous = null
    ) {
        parent::__construct($message, 0, $previous);
        $this->codigo = $codigo;
    }

    public function getCodigo(): string
    {
        return $this->codigo;
    }
}
