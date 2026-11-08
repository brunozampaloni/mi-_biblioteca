
<?php
require_once __DIR__ . "/../../controllers/HistorialController.php";

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit;
}

$usuarioId = $_SESSION["usuario_id"];

$historialController = new HistorialController();
$historial = $historialController->obtenerPorUsuario($usuarioId);
?>

<main class="container py-4">

    <!-- ENCABEZADO -->
    <div class="mb-4">
        <h1 class="fw-bold mb-2" style="color: #263f36;">
            <i class="bi bi-clock-history me-2"></i>
            Historial de actividad
        </h1>
    </div>


    <?php if (empty($historial)): ?>

        <!-- HISTORIAL VACÍO -->
        <div class="card border-0 rounded-4 shadow-sm">
            <div class="card-body text-center py-5 px-4">
                <div class="d-flex align-items-center justify-content-center rounded-circle mx-auto mb-3"
                     style="width: 80px; height: 80px; background-color: #e8f0eb;">

                    <i class="bi bi-clock-history fs-1"
                       style="color: #263f36;"></i>

                </div>
                <h2 class="h5 fw-bold mb-2" style="color: #263f36;">
                    Todavía no hay actividad
                </h2>
            </div>
        </div>

    <?php else: ?>


        <!-- LISTA DEL HISTORIAL -->
        <div class="d-flex flex-column gap-3">

            <?php foreach ($historial as $actividad): ?>

                <div class="card border-0 rounded-4 shadow-sm">

                    <div class="card-body p-4">

                        <div class="row g-3 align-items-start">
                            <!-- INFORMACIÓN -->
                            <div class="col">

                                <h3 class="h6 fw-bold mb-2"
                                    style="color: #263f36;">

                                    <?= htmlspecialchars(
                                        $actividad["tipo_historial"],
                                        ENT_QUOTES,
                                        "UTF-8"
                                    ) ?>

                                </h3>

                                <p class="text-secondary mb-3">
                                    <?= htmlspecialchars(
                                        $actividad["descripcion"],
                                        ENT_QUOTES,
                                        "UTF-8"
                                    ) ?>
                                </p>

                                <div class="d-flex align-items-center gap-2 text-secondary small">
                                    <span>
                                        <?= htmlspecialchars(
                                            $actividad["fecha_hora"],
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>
