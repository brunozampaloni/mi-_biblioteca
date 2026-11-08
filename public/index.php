<?php
session_start();
require_once __DIR__ . "/../support/RegistroAplicacion.php";



if (isset($_SESSION["usuario_id"])) {
    $view = $_GET["views"] ?? "dashboard";
} else {
    $view = $_GET["views"] ?? "loginRegistro/login";
}

?> 

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/styles/styles.css">
</head>

<body>

    
    <?php require_once "views/components/nav.php"; ?>

    <?php if (!empty($_SESSION["flash_error"])): ?>
        <div class="container pt-3">
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($_SESSION["flash_error"], ENT_QUOTES, "UTF-8") ?>
            </div>
        </div>
        <?php unset($_SESSION["flash_error"]); ?>
    <?php endif; ?>

    <main>
        <?php //momentanio
        try {
            if (file_exists("views/$view.php")) {
                require_once "views/$view.php";
            } else {
                require_once "views/ERROR/404.php";
            }
        } catch (Throwable $e) {
            (new RegistroAplicacion())->error("pagina.error", $e, ["vista" => (string) $view]);
            http_response_code(500);
            ?>
            <div class="container py-4">
                <div class="alert alert-danger" role="alert">
                    Ocurrió un error al cargar esta página. Intentá nuevamente.
                </div>
            </div>
            <?php
        }
        
        ?>
    </main>

    <?php require_once "views/components/footer.php"; ?>

</body>

