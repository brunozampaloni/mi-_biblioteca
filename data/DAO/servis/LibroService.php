<?php

require_once __DIR__ . "/../LibroDAO.php";
require_once __DIR__ . "/../interfaces/LibroDAOInterface.php";
require_once __DIR__ . "/../../../model/DTO/LibroDTO.php";
require_once __DIR__ . "/../../../model/DTO/LibroModificacionDTO.php";
require_once __DIR__ . "/../../../exceptions/RegistroDuplicadoException.php";
require_once __DIR__ . "/../../../exceptions/OperacionFallidaException.php";
require_once __DIR__ . "/../../../traits/LoggableTrait.php";

class LibroService
{
    use LoggableTrait;

    private LibroDAOInterface $libroDAO;

    public function __construct(?LibroDAOInterface $libroDAO = null)
    {
        $this->libroDAO = $libroDAO ?? new LibroDAO();
    }

    public function modificarEstado(LibroModificacionDTO $libro, int $usuarioId): bool
    {
        return $this->libroDAO->modificarEstado($libro, $usuarioId);
    }

    public function modificarPuntuacion(LibroModificacionDTO $libro, int $usuarioId): bool
    {
        return $this->libroDAO->modificarPuntuacion($libro, $usuarioId);
    }

    public function modificarResena(LibroModificacionDTO $libro, int $usuarioId): bool
    {
        return $this->libroDAO->modificarResena($libro, $usuarioId);
    }

    public function modificarImagen(LibroModificacionDTO $libro, int $usuarioId): bool
    {
        return $this->libroDAO->modificarImagen($libro, $usuarioId);
    }

    public function obtenerPorId(int $id, int $usuarioId): ?array
    {
        return $this->libroDAO->obtenerPorId($id, $usuarioId);
    }

    public function obtenerPorTitulo(string $titulo): array
    {
        return $this->libroDAO->obtenerPorTitulo($titulo);
    }

    public function obtenerPorGenero(int $generoId): array
    {
        return $this->libroDAO->obtenerPorGenero($generoId);
    }

    public function obtenerPorUsuario(int $usuarioId): array
    {
        return $this->libroDAO->obtenerPorUsuario($usuarioId);
    }

    public function existeLibro(
        int $usuarioId,
        string $titulo,
        string $autor,
        int $generoId,
        int $anoDePublicacion
    ): bool {
        return $this->libroDAO->existeLibro(
            $usuarioId,
            $titulo,
            $autor,
            $generoId,
            $anoDePublicacion
        );
    }

    public function obtenerDatosParaCSV(int $usuarioId): array
    {
        return $this->libroDAO->obtenerDatosParaCSV($usuarioId);
    }

    public function eliminar(int $libroId, int $usuarioId): bool
    {
        return $this->libroDAO->eliminar($libroId, $usuarioId);
    }

    public function registrarLibro(
        LibroDTO $libro,
        int $usuarioId
    ): bool {

        // Comprobar si el libro ya está registrado.
        if ($this->libroDAO->existeLibro(
            $usuarioId,
            $libro->getTitulo(),
            $libro->getAutor(),
            $libro->getGeneroId(),
            $libro->getAnoDePublicacion()
        )) {
            throw new RegistroDuplicadoException(
                "libro",
                "Ese libro ya está registrado en tu biblioteca."
            );
        }

        // Registrar el libro en la base de datos.
        $registrado = $this->libroDAO->registrar(
            $libro,
            $usuarioId
        );

        if (!$registrado) {
            throw new OperacionFallidaException("No se pudo registrar el libro.");
        }

        $this->logInfo(
            "libro.alta_exitosa",
            "Se agregó un libro a la biblioteca.",
            ["usuario_id" => $usuarioId]
        );
        return true;
    }
}
