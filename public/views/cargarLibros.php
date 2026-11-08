<?php

require_once __DIR__ ."/../../data/DAO/servis/GeneroService.php";

$generoService = new GeneroService();
$generos = $generoService->obtenerGeneros();

?>



<head>
    <meta charset="UTF-8">
    <title>Agregar libro</title>
</head>






<section class="container py-4 py-md-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-9 col-xl-8">

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">

                    <div class="mb-4">
                        <h1 class="fw-bold mb-2" style="color: #263f36;">
                            Agregar un libro
                        </h1>
                        <p class="text-secondary mb-0">
                            Completá los datos para sumar una nueva lectura a tu biblioteca.
                        </p>
                    </div>

                    <form enctype="multipart/form-data" action="../controllers/procesarLibro.php" method="POST">

                        <div class="row g-3">

                            <div class="col-12 col-md-6">
                                <label for="titulo" class="form-label">Título</label>
                                <input type="text" id="titulo" name="titulo"
                                       class="form-control" required>
                                       
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="autor" class="form-label">Autor</label>
                                <input type="text" id="autor" name="autor"
                                       class="form-control" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="genero_id" class="form-label">Género</label>
                                <select id="genero_id" name="genero_id"
                                        class="form-select" required>

                                    <option value="">Seleccione un género</option>

                                    <?php foreach ($generos as $genero): ?>
                                        <option value="<?= $genero['id'] ?>">
                                            <?= htmlspecialchars($genero['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>

                                </select>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="anoDePublicacion" class="form-label">
                                    Año de publicación
                                </label>
                                <input type="number" id="anoDePublicacion"
                                       name="anoDePublicacion"
                                       class="form-control" required>
                            </div>

                            <div class="col-12">
                                <label for="editorial" class="form-label">Editorial</label>
                                <input type="text" id="editorial" name="editorial"
                                       class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label for="imagen" class="form-label">
                                    Portada del libro
                                </label>
                                <input type="file" id="imagen" name="imagen"
                                       class="form-control" accept="image/*" required>
                            </div>
                            <div class="col-12 pt-2">
                                <button type="submit" class="btn btn-success px-4">
                                    Agregar libro
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</section>
