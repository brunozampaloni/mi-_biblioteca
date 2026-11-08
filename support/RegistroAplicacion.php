<?php
declare(strict_types=1);

require_once __DIR__ . "/../traits/LoggableTrait.php";
class RegistroAplicacion
{
    use LoggableTrait;

    public function info(string $evento, string $mensaje, array $contexto = []): void
    {
        $this->logInfo($evento, $mensaje, $contexto);
    }

    public function warning(string $evento, string $mensaje, array $contexto = []): void
    {
        $this->logWarning($evento, $mensaje, $contexto);
    }

    public function error(string $evento, Throwable $exception, array $contexto = []): void
    {
        $contexto["excepcion"] = get_class($exception);
        $contexto["detalle"] = $exception->getMessage();
        $this->logError($evento, "La operación terminó con una excepción.", $contexto);
    }
}
