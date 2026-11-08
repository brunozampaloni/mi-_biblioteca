<?php
declare(strict_types=1);

require_once __DIR__ . '/../support/logger.php';

trait LoggableTrait {
    private ?Logger $logger = null;

    public function setLogger(Logger $logger): void {
        $this->logger = $logger;
    }

    protected function logInfo(string $evento, string $mensaje, array $contexto = []): void {
        $this->obtenerLogger()->info($evento, $mensaje, $contexto);
    }

    protected function logWarning(string $evento, string $mensaje, array $contexto = []): void {
        $this->obtenerLogger()->warning($evento, $mensaje, $contexto);
    }

    protected function logError(string $evento, string $mensaje, array $contexto = []): void {
        $this->obtenerLogger()->error($evento, $mensaje, $contexto);
    }

    private function obtenerLogger(): Logger {
        if ($this->logger === null) {
            $this->logger = new Logger();
        }

        return $this->logger;
    }
}
