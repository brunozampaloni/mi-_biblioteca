<?php
declare(strict_types=1);
class Logger
{
    private string $rutaArchivo;

    public function __construct(?string $rutaArchivo = null)
    {
        $this->rutaArchivo = $rutaArchivo ?? dirname(__DIR__) . "/logs/registroDelSistema.log";
    }

    public function log(string $nivel, string $evento, string $mensaje, array $contexto = []): void
    {
        $evento = str_replace(["\r", "\n"], ["\\r", "\\n"], $evento);
        $mensaje = str_replace(["\r", "\n"], ["\\r", "\\n"], $mensaje);
        $contexto = $this->filtrarContexto($contexto);
        $textoContexto = $contexto === []
            ? ""
            : " | contexto=" . json_encode($contexto, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $linea = sprintf(
            "[%s] [%s] [%s] %s%s",
            date("Y-m-d H:i:s P"),
            strtoupper($nivel),
            $evento,
            $mensaje,
            $textoContexto
        );

        $directorio = dirname($this->rutaArchivo);
        if (!is_dir($directorio) && !@mkdir($directorio, 0750, true) && !is_dir($directorio)) {
            error_log("No se pudo crear el directorio de logs de la aplicación.");
            return;
        }

        if (@file_put_contents($this->rutaArchivo, $linea . PHP_EOL, FILE_APPEND | LOCK_EX) === false) {
            error_log("No se pudo escribir en el log de la aplicación.");
        }
    }

    public function info(string $evento, string $mensaje, array $contexto = []): void
    {
        $this->log("INFO", $evento, $mensaje, $contexto);
    }

    public function warning(string $evento, string $mensaje, array $contexto = []): void
    {
        $this->log("WARNING", $evento, $mensaje, $contexto);
    }

    public function error(string $evento, string $mensaje, array $contexto = []): void
    {
        $this->log("ERROR", $evento, $mensaje, $contexto);
    }

    private function filtrarContexto(array $contexto): array
    {
        $clavesSensibles = [
            "password",
            "contrasena",
            "confirmacionpassword",
            "token",
            "authorization",
            "cookie",
            "email",
        ];
        foreach ($contexto as $clave => $valor) {
            $claveNormalizada = strtolower((string) preg_replace('/[^a-zA-Z0-9]/', '', (string) $clave));
            if (in_array($claveNormalizada, $clavesSensibles, true)) {
                $contexto[$clave] = "[REDACTADO]";
            } elseif (is_array($valor)) {
                $contexto[$clave] = $this->filtrarContexto($valor);
            }
        }

        return $contexto;
    }
}
