
<?php
require_once __DIR__ . "/../../controllers/busquedaController.php";
?>

<section class="container py-5">

    <!-- ENCABEZADO -->
    <div class="mb-4">
        <h1 class="fw-bold mt-3" style="color: #263f36;">
            Buscar libros
        </h1>
    </div>

    <!-- FORMULARIO DE BÚSQUEDA -->
    <div class="card border-0 shadow-sm rounded-4 mb-5">
        <div class="card-body p-4">

            <form action="index.php" method="GET">

                <input type="hidden" name="views" value="busqueda">

                <!-- TÉRMINO DE BÚSQUEDA -->
                <div class="mb-4">
                    <label for="terminoBusqueda"
                           class="form-label fw-semibold">
                        Título o autor
                    </label>

                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>

                        <input
                            type="search"
                            class="form-control"
                            id="terminoBusqueda"
                            name="terminoBusqueda"
                            placeholder="Ej. Harry Potter o J. K. Rowling"
                            value="<?= htmlspecialchars($terminoBusqueda, ENT_QUOTES, 'UTF-8') ?>"
                        >
                    </div>
                </div>

                <!-- como el formulario de modificar-->
                <div class="row g-3">

                    <div class="col-12 col-md-4">
                        <label for="genero_id"
                               class="form-label fw-semibold">
                            Género
                        </label>

                        <select class="form-select"
                                id="genero_id"
                                name="genero_id">

                            <option value="0">Todos los géneros</option>

                            <?php foreach ($generos as $genero): ?>
                                <option
                                    value="<?= (int) $genero["id"] ?>"
                                    <?= $generoId === (int) $genero["id"] ? "selected" : "" ?>
                                >
                                    <?= htmlspecialchars($genero["nombre"], ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="estado_lectura"
                               class="form-label fw-semibold">
                            Estado de lectura
                        </label>

                        <select class="form-select"
                                id="estado_lectura"
                                name="estado_lectura">

                            <option value="">Todos los estados</option>

                            <option value="Pendiente"
                                <?= $estadoLectura === "Pendiente" ? "selected" : "" ?>>
                                Pendiente
                            </option>

                            <option value="Leyendo"
                                <?= $estadoLectura === "Leyendo" ? "selected" : "" ?>>
                                Leyendo
                            </option>

                            <option value="Leído"
                                <?= $estadoLectura === "Leído" ? "selected" : "" ?>>
                                Leído
                            </option>

                            <option value="Abandonado"
                                <?= $estadoLectura === "Abandonado" ? "selected" : "" ?>>
                                Abandonado
                            </option>

                        </select>
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="puntuacion"
                               class="form-label fw-semibold">
                            Puntuación
                        </label>

                        <select class="form-select"
                                id="puntuacion"
                                name="puntuacion">

                            <option value="0">Cualquier puntuación</option>

                            <?php for ($i = 5; $i >= 1; $i--): ?>
                                <option
                                    value="<?= $i ?>"
                                    <?= $puntuacion === $i ? "selected" : "" ?>
                                >
                                    <?= $i ?> <?= $i === 1 ? "estrella" : "estrellas" ?>
                                </option>
                            <?php endfor; ?>

                        </select>
                    </div>

                </div>

                <div class="d-flex flex-wrap gap-2 mt-4">
                    <button type="submit"
                            class="btn btn-success px-4 fw-semibold">
                        <i class="bi bi-search me-1"></i>
                        Buscar libros
                    </button>
                </div>

            </form>

        </div>
    </div>

    <!-- RESULTADOS -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 fw-bold mb-0" style="color: #263f36;">
            Resultados
        </h2>

        <span class="badge rounded-pill text-bg-light border">
            <?= $totalResultados ?>
            <?= $totalResultados === 1 ? "libro" : "libros" ?>
        </span>
    </div>

    <?php if (empty($resultadosBusqueda)): ?>

        <div class="text-center bg-light rounded-4 p-5">
            <i class="bi bi-book display-4 text-secondary"></i>

            <h3 class="h5 fw-bold mt-3" style="color: #263f36;">
                No encontramos libros
            </h3>

            <p class="text-secondary mb-3">
                Probá cambiar las palabras o quitar alguno de los filtros.
            </p>

            <a href="index.php?views=busqueda"
               class="btn btn-outline-success">
                Ver todos mis libros
            </a>
        </div>

    <?php else: ?>

        <div class="row g-4">

            <?php foreach ($resultadosBusqueda as $libro): ?>

                <div class="col-6 col-md-4 col-lg-3">

                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">

                        <a
                            href="index.php?views=dashboardLibro&id=<?= (int) $libro["id"] ?>"
                            class="text-decoration-none"
                        >
                            <?php if (!empty($libro["imagen"])): ?>

                                <img
                                    src="<?= htmlspecialchars($libro["imagen"], ENT_QUOTES, 'UTF-8') ?>"
                                    alt="Portada de <?= htmlspecialchars($libro["titulo"], ENT_QUOTES, 'UTF-8') ?>"
                                    class="card-img-top"
                                    loading="lazy"
                                    style="height: 260px; object-fit: cover;"
                                >

                            <?php else: ?>

                                <div class="d-flex align-items-center justify-content-center bg-light"
                                     style="height: 260px;">
                                    <i class="bi bi-book display-3 text-secondary"></i>
                                </div>

                            <?php endif; ?>
                        </a>

                        <div class="card-body d-flex flex-column">

                            <h3 class="h6 fw-bold mb-2">
                                <a
                                    href="index.php?views=dashboardLibro&id=<?= (int) $libro["id"] ?>"
                                    class="text-decoration-none"
                                    style="color: #263f36;"
                                >
                                    <?= htmlspecialchars($libro["titulo"], ENT_QUOTES, 'UTF-8') ?>
                                </a>
                            </h3>

                            <p class="text-secondary small mb-2">
                                <?= htmlspecialchars($libro["autor"], ENT_QUOTES, 'UTF-8') ?>
                            </p>

                            <p class="small mb-2">
                                <i class="bi bi-bookmark me-1"></i>
                                <?= htmlspecialchars($libro["genero"], ENT_QUOTES, 'UTF-8') ?>
                            </p>

                            <div class="mt-auto pt-2">

                                <?php if (!empty($libro["estado_lectura"])): ?>
                                    <span class="badge rounded-pill text-bg-success mb-2">
                                        <?= htmlspecialchars($libro["estado_lectura"], ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                <?php else: ?>
                                    <span class="badge rounded-pill text-bg-light border mb-2">
                                        Sin estado
                                    </span>
                                <?php endif; ?>

                                <div class="small" style="color: #b8860b;">
                                    <?php if ($libro["puntuacion"] !== null): ?>

                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <?= $i <= (int) $libro["puntuacion"] ? "★" : "☆" ?>
                                        <?php endfor; ?>

                                    <?php else: ?>

                                        <span class="text-secondary">
                                            Sin puntuación
                                        </span>

                                    <?php endif; ?>
                                </div>

                                <a
                                    href="index.php?views=dashboardLibro&id=<?= (int) $libro["id"] ?>"
                                    class="btn btn-outline-success btn-sm w-100 mt-3"
                                >
                                    Ver libro
                                </a>

                            </div>

                        </div>
                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</section>
