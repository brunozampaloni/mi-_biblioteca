
<?php
require_once __DIR__ . "/../../controllers/dashboardLibroController.php";
?>

<main class="container py-4">

    <!-- ENCABEZADO -->
    <div class="mb-4">
        <h1 class="fw-bold mb-2" style="color: #263f36;">
            <?= htmlspecialchars($libro["titulo"]) ?>
        </h1>
    </div>



    <!--LA IMAGEN DEL LIBRO-->
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body p-4">

            <h2 class="h5 fw-bold mb-4" style="color: #263f36;">
                <i class="bi bi-book-half me-2"></i>
                Portada del libro
            </h2>

            <div class="row g-4 align-items-center">

                <div class="col-12 col-md-4 text-center">

                    <?php if (!empty($libro["imagen"])): ?>

                        <img
                            src="<?= htmlspecialchars($libro["imagen"]) ?>"
                            alt="Portada de <?= htmlspecialchars($libro["titulo"]) ?>"
                            class="img-fluid rounded-3"
                            style="max-height: 350px; object-fit: contain;"
                        >

                    <?php else: ?>

                        <div class="rounded-4 d-flex flex-column align-items-center justify-content-center p-5"
                             style="background-color: #e8f0eb; min-height: 250px;">

                            <i class="bi bi-book fs-1 mb-3"
                               style="color: #263f36;"></i>

                            <p class="text-secondary mb-0">
                                Este libro no tiene portada.
                            </p>

                        </div>

                    <?php endif; ?>

                </div>

                <div class="col-12 col-md-8">

                    <h3 class="h6 fw-bold mb-2" style="color: #263f36;">
                        Actualizar portada
                    </h3>

                    <p class="text-secondary small mb-3">
                        Elegí una imagen para personalizar la portada de tu libro.
                    </p>

                    <form
                        action="../controllers/procesarModificacionLibro.php"
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        <input type="hidden" name="id"
                               value="<?= $libro["id"] ?>">

                        <input type="hidden" name="campo"
                               value="imagen">

                        <label for="imagen" class="form-label fw-semibold">
                            Seleccionar imagen
                        </label>

                        <input
                            type="file"
                            class="form-control mb-3"
                            id="imagen"
                            name="imagen"
                            accept="image/*"
                            required
                        >

                        <button type="submit"
                                class="btn text-white rounded-3 px-4"
                                style="background-color: #263f36;">
                            <i class="bi bi-upload me-2"></i>
                            Cambiar portada
                        </button>

                    </form>

                </div>
            </div>
        </div>
    </div>





    <!-- ESTADO DE LECTURA -->
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body p-4">

            <h2 class="h5 fw-bold mb-3" style="color: #263f36;">
                <i class="bi bi-bookmark-check me-2"></i>
                Estado de lectura
            </h2>

            <p class="text-secondary small mb-1">Estado actual</p>

            <div class="mb-4">
                <?php if (!empty($libro["estado_lectura"])): ?>

                    <?php
                    $coloresEstado = [
                        "Pendiente" => "warning",
                        "Leyendo" => "primary",
                        "Leído" => "success",
                        "Abandonado" => "secondary"
                    ];

                    $estadoActual = $libro["estado_lectura"];
                    $colorEstado = $coloresEstado[$estadoActual] ?? "secondary";
                    ?>

                    <span class="badge bg-<?= $colorEstado ?> rounded-pill px-3 py-2">
                        <?= htmlspecialchars($estadoActual) ?>
                    </span>

                <?php else: ?>

                    <span class="badge bg-secondary rounded-pill px-3 py-2">
                        Sin estado
                    </span>

                <?php endif; ?>
            </div>

            <form
                action="../controllers/procesarModificacionLibro.php"
                method="POST"
            >

                <input type="hidden" name="id"
                       value="<?= $libro["id"] ?>">

                <input type="hidden" name="campo"
                       value="estado">

                <label for="estado_lectura" class="form-label fw-semibold">
                    Modificar estado
                </label>

                <select
                    id="estado_lectura"
                    name="estado"
                    class="form-select mb-3"
                    required
                >

                    <option value="">Seleccione un estado</option>

                    <option value="Pendiente"
                        <?= $libro["estado_lectura"] === "Pendiente" ? "selected" : "" ?>>
                        Pendiente
                    </option>

                    <option value="Leyendo"
                        <?= $libro["estado_lectura"] === "Leyendo" ? "selected" : "" ?>>
                        Leyendo
                    </option>

                    <option value="Leído"
                        <?= $libro["estado_lectura"] === "Leído" ? "selected" : "" ?>>
                        Leído
                    </option>

                    <option value="Abandonado"
                        <?= $libro["estado_lectura"] === "Abandonado" ? "selected" : "" ?>>
                        Abandonado
                    </option>

                </select>

                <button type="submit"
                        class="btn text-white rounded-3 px-4"
                        style="background-color: #263f36;">
                    Guardar estado
                </button>

            </form>
        </div>
    </div>


    <!-- PUNTUACIÓN -->
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body p-4">

            <h2 class="h5 fw-bold mb-3" style="color: #263f36;">
                <i class="bi bi-star me-2"></i>
                Puntuación
            </h2>

            <p class="text-secondary small mb-2">
                Tu valoración del libro
            </p>

            <div class="fs-3 mb-4" style="color: #d49a28;">
                <?php if (!empty($libro["puntuacion"])): ?>

                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <?= $i <= (int) $libro["puntuacion"] ? "★" : "☆" ?>
                    <?php endfor; ?>

                <?php else: ?>

                    <span class="text-secondary fs-6">
                        Sin puntuación
                    </span>

                <?php endif; ?>
            </div>

            <?php if ($libro["estado_lectura"] === "Leído"): ?>

                <form
                    action="../controllers/procesarModificacionLibro.php"
                    method="POST"
                >

                    <input type="hidden" name="id"
                           value="<?= $libro["id"] ?>">

                    <input type="hidden" name="campo"
                           value="puntuacion">

                    <p class="fw-semibold mb-3" style="color: #263f36;">
                        Seleccioná una puntuación
                    </p>

                    <div class="d-flex flex-wrap gap-3 mb-4">

                        <?php for ($i = 1; $i <= 5; $i++): ?>

                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="puntuacion"
                                    id="puntuacion<?= $i ?>"
                                    value="<?= $i ?>"
                                    <?= (int) $libro["puntuacion"] === $i ? "checked" : "" ?>
                                    required
                                >

                                <label class="form-check-label"
                                       for="puntuacion<?= $i ?>">
                                    <?= $i ?> ★
                                </label>
                            </div>

                        <?php endfor; ?>

                    </div>

                    <button type="submit"
                            class="btn text-white rounded-3 px-4"
                            style="background-color: #263f36;">
                        Guardar puntuación
                    </button>

                </form>

            <?php else: ?>

                <div class="alert alert-light border rounded-3 mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    Solo podés puntuar un libro cuando su estado sea "Leído".
                </div>

            <?php endif; ?>

        </div>
    </div>


    <!-- RESEÑA -->
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body p-4">

            <h2 class="h5 fw-bold mb-3" style="color: #263f36;">
                <i class="bi bi-journal-text me-2"></i>
                Reseña personal
            </h2>

            <?php if (!empty($libro["resena"])): ?>

                <div class="rounded-3 p-3 mb-4"
                     style="background-color: #f5f3ee;">

                    <p class="mb-0" style="white-space: pre-line;">
                        <?= htmlspecialchars($libro["resena"]) ?>
                    </p>

                </div>

            <?php else: ?>

                <p class="text-secondary mb-4">
                    Todavía no escribiste una reseña para este libro.
                </p>

            <?php endif; ?>

            <form
                action="../controllers/procesarModificacionLibro.php"
                method="POST"
            >

                <input type="hidden" name="id"
                       value="<?= $libro["id"] ?>">

                <input type="hidden" name="campo"
                       value="resena">

                <label for="resena" class="form-label fw-semibold">
                    <?= !empty($libro["resena"])
                        ? "Modificar reseña"
                        : "Escribir una reseña" ?>
                </label>

                <textarea
                    id="resena"
                    name="resena"
                    class="form-control mb-3"
                    rows="6"
                    placeholder="Escribí tu opinión sobre el libro..."
                    required
                ><?= htmlspecialchars($libro["resena"] ?? "") ?></textarea>

                <button type="submit"
                        class="btn text-white rounded-3 px-4"
                        style="background-color: #263f36;">
                    <i class="bi bi-check2 me-2"></i>
                    Guardar reseña
                </button>

            </form>
        </div>
    </div>





    <!-- ELIMINAR LIBRO -->
    <div class="card border border-danger-subtle rounded-4 mb-4">
        <div class="card-body p-4">

            <h2 class="h5 fw-bold text-danger mb-2">
                <i class="bi bi-trash me-2"></i>
                Eliminar libro
            </h2>
            <a
                href="../controllers/porcesarEliminacionLibro.php?id=<?= (int) $libro["id"] ?>"
                class="btn btn-outline-danger rounded-3"
                
                onclick="return confirm('¿Estás seguro de que querés eliminar este libro?');"
            >
                <i class="bi bi-trash me-2"></i>
                Eliminar libro
            </a>

        </div>
    </div>

</main>
