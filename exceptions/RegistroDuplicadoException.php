<?php

require_once __DIR__ . "/generalException.php";

/** Conflicto de unicidad durante el registro de datos. */
class RegistroDuplicadoException extends GeneralException
{
    private string $campo;

    public function __construct(string $campo, string $message)
    {
        parent::__construct($message);
        $this->campo = $campo;
    }

    public function getCampo(): string
    {
        return $this->campo;
    }
}
