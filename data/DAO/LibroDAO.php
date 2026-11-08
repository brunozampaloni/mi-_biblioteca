<?php

require_once __DIR__ . "/../../model/DTO/LibroDTO.php";
require_once __DIR__ . "/../../model/DTO/LibroModificacionDTO.php";
require_once __DIR__ . "/../../data/Conexion.php";
require_once __DIR__ . "/interfaces/LibroDAOInterface.php";

class LibroDAO implements LibroDAOInterface
{
    private PDO $pdo;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->pdo = $conexion->conectar();
    }


    //REGISTRAR LIBRO

    public function registrar(LibroDTO $libro, int $usuarioId): bool
    {
        $sql = "INSERT INTO libros
                (usuario_id, titulo, autor, genero_id, ano_publicacion, editorial, imagen)
                VALUES
                (:usuario_id, :titulo, :autor, :genero_id, :ano_publicacion, :editorial, :imagen)";

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            "usuario_id" => $usuarioId,
            "titulo" => $libro->getTitulo(),
            "autor" => $libro->getAutor(),
            "genero_id" => $libro->getGeneroId(),
            "ano_publicacion" => $libro->getAnoDePublicacion(),
            "editorial" => $libro->getEditorial(),
            "imagen" => $libro->getImagen()
        ]);

        return $consulta->rowCount() > 0;
    }



    //MODIFICAR LIBRO

    public function modificarEstado(LibroModificacionDTO $libro, int $usuarioId): bool
    {
        $sql = "UPDATE libros
                SET estado_lectura = :estado
                WHERE id = :id
                AND usuario_id = :usuario_id";

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            "estado" => $libro->getEstadoDeLectura(),
            "id" => $libro->getId(),
            "usuario_id" => $usuarioId
        ]);

        return $consulta->rowCount() > 0;
    }
       

    public function modificarPuntuacion(LibroModificacionDTO $libro, int $usuarioId): bool
    {
        $sql = "UPDATE libros
                SET puntuacion = :puntuacion
                WHERE id = :id
                AND usuario_id = :usuario_id";

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            "puntuacion" => $libro->getPuntuacionPersonal(),
            "id" => $libro->getId(),
            "usuario_id" => $usuarioId
        ]);

        return $consulta->rowCount() > 0;
    }

    public function modificarResena(LibroModificacionDTO $libro, int $usuarioId): bool
    {
        $sql = "UPDATE libros
                SET resena = :resena
                WHERE id = :id
                AND usuario_id = :usuario_id";

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            "resena" => $libro->getResena(),
            "id" => $libro->getId(),
            "usuario_id" => $usuarioId
        ]);

        return $consulta->rowCount() > 0;
    }

    public function modificarImagen(LibroModificacionDTO $libro, int $usuarioId): bool
    {
        $sql = "UPDATE libros
                SET imagen = :imagen
                WHERE id = :id
                AND usuario_id = :usuario_id";

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            "imagen" => $libro->getImagen(),
            "id" => $libro->getId(),
            "usuario_id" => $usuarioId
        ]);

        return $consulta->rowCount() > 0;
    }



    //OBTENER INFO DE LIBRO

    public function obtenerPorTitulo(string $titulo): array
    {
        $sql = "SELECT id, usuario_id, titulo, autor, genero_id,
                       ano_publicacion, editorial, estado_lectura,
                       puntuacion, resena, imagen
                FROM libros
                WHERE titulo = :titulo";

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            "titulo" => $titulo
        ]);

        return $consulta->fetchAll();
    }

    public function obtenerPorGenero(int $generoId): array
    {
        $sql = "SELECT id, usuario_id, titulo, autor, genero_id,
                       ano_publicacion, editorial, estado_lectura,
                       puntuacion, resena, imagen
                FROM libros
                WHERE genero_id = :genero_id";

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            "genero_id" => $generoId
        ]);

        return $consulta->fetchAll();
    }

    public function obtenerPorUsuario(int $usuarioId): array
    {
        $sql = "SELECT id, usuario_id, titulo, autor, genero_id,
                       ano_publicacion, editorial, estado_lectura,
                       puntuacion, resena, imagen
                FROM libros
                WHERE usuario_id = :usuario_id";

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            "usuario_id" => $usuarioId
        ]);

        return $consulta->fetchAll();
    }

    public function obtenerPorId(int $id, int $usuarioId): ?array
    {
        $sql = "SELECT id, usuario_id, titulo, autor, genero_id,
                       ano_publicacion, editorial, estado_lectura,
                       puntuacion, resena, imagen
                FROM libros
                WHERE id = :id
                AND usuario_id = :usuario_id";

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            "id" => $id,
            "usuario_id" => $usuarioId
        ]);

        $libro = $consulta->fetch();

        if ($libro === false) {
            return null;
        }

        return $libro;
    }








    public function obtenerDatosParaCSV(int $usuarioId): array
    {
        $sql = "SELECT 
                    libros.titulo,
                    generos.nombre AS genero,
                    libros.autor,
                    libros.ano_publicacion,
                    libros.editorial
                FROM libros
                INNER JOIN generos ON libros.genero_id = generos.id
                WHERE libros.usuario_id = :usuario_id";

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            "usuario_id" => $usuarioId
        ]);

        return $consulta->fetchAll();
    }








    public function existeLibro(
        int $usuarioId,
        string $titulo,
        string $autor,
        int $generoId,
        int $anoDePublicacion
    ): bool {

        $sql = "SELECT id
                FROM libros
                WHERE usuario_id = :usuario_id
                AND titulo = :titulo
                AND autor = :autor
                AND genero_id = :genero_id
                AND ano_publicacion = :ano_publicacion
                LIMIT 1";

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            "usuario_id" => $usuarioId,
            "titulo" => $titulo,
            "autor" => $autor,
            "genero_id" => $generoId,
            "ano_publicacion" => $anoDePublicacion
        ]);

        return $consulta->fetch() !== false;
    }

    public function eliminar(int $libroId, int $usuarioId): bool
    {
        $sql = "DELETE FROM libros
                WHERE id = :id
                AND usuario_id = :usuario_id";

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            "id" => $libroId,
            "usuario_id" => $usuarioId
        ]);

        return $consulta->rowCount() > 0;
    }






}
