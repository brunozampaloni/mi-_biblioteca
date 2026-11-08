
<?php
require_once __DIR__ . "/../../controllers/dashboardController.php";
?>
    <section class="container py-4">
        <div class="p-4 p-md-5 rounded-4 text-white"
            style="background: linear-gradient(135deg, #263f36, #198754);">


            <h1 class="fw-bold">
                Mi biblioteca.
            </h1>

            <p class="mb-4">
                Organizá tus lecturas y descubrí tu próxima historia favorita.
            </p>

            <a href="index.php?views=cargarLibros"
            class="btn btn-light fw-semibold">
                + Agregar un libro
            </a>
            <a href="index.php?views=busqueda" class="btn btn-light fw-semibold">
                Buscar libros
            </a>
                        <a href="../controllers/ExportarBibliotecaController.php" class="btn btn-light fw-semibold">
                Descargar CSV
            </a>

        </div>
    </section>




<section class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #263f36;">
                Mis libros
            </h2>
        </div>
    </div>
    <div class="row g-4">
        <?php foreach ($todosLosLibros as $libro): ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <a href="index.php?views=dashboardLibro&id=<?= (int) $libro["id"] ?>"
                       class="text-decoration-none">
                        <img
                            src="<?= htmlspecialchars($libro["imagen"]) ?>"
                            alt="Portada de <?= htmlspecialchars($libro["titulo"]) ?>"
                            class="card-img-top"
                            style="height: 240px; object-fit: cover;"
                        >
                    </a>
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-0">
                            <a
                                href="index.php?views=dashboardLibro&id=<?= (int) $libro["id"] ?>"
                                class="text-decoration-none"
                                style="color: #263f36;"
                            >
                                <?= htmlspecialchars($libro["titulo"]) ?>
                            </a>
                        </h5>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>





<section class="container py-4">

    <h2 class="fw-bold mb-4" style="color: #263f36;">
        Estadísticas
    </h2>

    <div class="row g-3">

        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <p class="text-secondary mb-2">Total de libros</p>
                    <h3 class="fw-bold mb-0" style="color: #263f36;">
                        <?= $totalLibros ?>
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <p class="text-secondary mb-2">Libros leídos</p>
                    <h3 class="fw-bold mb-0 text-success">
                        <?= $librosLeidos ?>
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <p class="text-secondary mb-2">Libros pendientes</p>
                    <h3 class="fw-bold mb-0" style="color: #198754;">
                        <?= $librosPendientes ?>
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <p class="text-secondary mb-2">Libros leyendo</p>
                    <h3 class="fw-bold mb-0" style="color: #263f36;">
                        <?= $librosLeyendo ?>
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <p class="text-secondary mb-2">Promedio de puntuación</p>
                    <h3 class="fw-bold mb-0" style="color: #198754;">
                        <?= $promedioPuntuacion ?>
                    </h3>
                </div>
            </div>
        </div>

    </div>

</section>



  



 
<section class="container py-4">
    <div class="mb-4">
        <h2 class="fw-bold mb-1" style="color: #263f36;">
            Últimos libros agregados
        </h2>
        <p class="text-secondary mb-0">
            Descubrí los últimos libros que sumaste a tu biblioteca.
        </p>
    </div>

    <?php if ($mensajeUltimosAgregados !== null): ?>

        <div class="alert alert-light border rounded-3">
            <?= htmlspecialchars($mensajeUltimosAgregados) ?>
        </div>

    <?php else: ?>

        <div class="row g-3">
            <?php foreach ($ultimosLibrosAgregados as $libro): ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <a href="index.php?views=dashboardLibro&id=<?= (int) $libro["id"] ?>"
                       class="text-decoration-none">
                        <img
                            src="<?= htmlspecialchars($libro["imagen"]) ?>"
                            alt="Portada de <?= htmlspecialchars($libro["titulo"]) ?>"
                            class="card-img-top"
                            style="height: 240px; object-fit: cover;"
                        >
                    </a>
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-0">
                            <a
                                href="index.php?views=dashboardLibro&id=<?= (int) $libro["id"] ?>"
                                class="text-decoration-none"
                                style="color: #263f36;"
                            >
                                <?= htmlspecialchars($libro["titulo"]) ?>
                            </a>
                        </h5>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</section>






<section class="container py-4">
    <div class="mb-4">
        <h2 class="fw-bold mb-1" style="color: #263f36;">
            Últimos libros leidos
        </h2>
    </div>

    <?php if ($mensajeUltimosAgregados !== null): ?>

        <div class="alert alert-light border rounded-3">
            <?= htmlspecialchars($mensajeUltimosAgregados) ?>
        </div>

    <?php else: ?>

        <div class="row g-3">
            <?php foreach ($ultimosLibrosLeidos as $libro): ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <a href="index.php?views=dashboardLibro&id=<?= (int) $libro["id"] ?>"
                       class="text-decoration-none">
                        <img
                            src="<?= htmlspecialchars($libro["imagen"]) ?>"
                            alt="Portada de <?= htmlspecialchars($libro["titulo"]) ?>"
                            class="card-img-top"
                            style="height: 240px; object-fit: cover;"
                        >
                    </a>
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-0">
                            <a
                                href="index.php?views=dashboardLibro&id=<?= (int) $libro["id"] ?>"
                                class="text-decoration-none"
                                style="color: #263f36;"
                            >
                                <?= htmlspecialchars($libro["titulo"]) ?>
                            </a>
                        </h5>
                        <h5 class="card-title fw-bold mb-0" class="text-decoration-none"
                                style="color: #263f36;">
                             Puntuación:
                        <?= $libro["puntuacion"] ?? "Sin puntuación" ?>
                        </h5>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</section>


<section class="container py-4">
    <div class="mb-4">
        <h2 class="fw-bold mb-2" style="color: #263f36;">
            Mis generos
        </h2>

    </div>

    <?php if ($mensajeGeneros !== null): ?>

        <div class="alert alert-light border rounded-4">
            <?= htmlspecialchars($mensajeGeneros) ?>
        </div>

    <?php else: ?>

        <div class="row g-4">
            <?php foreach ($generosMasFrecuentes as $genero): ?>

                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card h-100 border rounded-4"
                         style="background-color: #ffffff; border-color: #e5e7e3 !important;">

                        <div class="card-body p-4">



                            <h3 class="fw-bold mb-3"
                                style="color: #263f36;">
                                <?= htmlspecialchars($genero["nombre"]) ?>
                            </h3>
                            <p class="fw-bold fs-2 mb-0"
                               style="color: #198754;">
                                <?= (int) $genero["cantidad"] ?>
                            </p>

                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</section>
