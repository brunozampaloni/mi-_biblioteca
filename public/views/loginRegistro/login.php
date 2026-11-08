<?php
$error = $_GET["error"] ?? "";

$mensajes = [
    "campos" => "Completá el usuario y la contraseña antes de continuar.",
    "credenciales" => "El usuario o la contraseña son incorrectos. Verificá los datos e intentá nuevamente.",
    "sistema" => "Ocurrió un problema al iniciar sesión. Intentá nuevamente."
];

$mensaje = $mensajes[$error] ?? "";
$registroExitoso = ($_GET["registro"] ?? "") === "exitoso";
?>

<div class="container py-5">
    <div class="card shadow-sm border-0 mx-auto" style="max-width: 420px;" >
        <div class="card-body p-4">

            <h1 class="h3 text-center mb-2">Iniciar sesión</h1>

            <p class="text-center text-muted mb-4">
                Ingresá tus datos para acceder a tu biblioteca.
            </p>

            <?php if ($mensaje !== ""): ?>
                <div class="alert alert-danger rounded-3" role="alert" aria-live="polite">
                    <strong class="d-block mb-1">&#9888; No se pudo iniciar sesión</strong>
                    <?= htmlspecialchars($mensaje, ENT_QUOTES, "UTF-8") ?>
                </div>
            <?php elseif ($registroExitoso): ?>
                <div class="alert alert-success rounded-3" role="status" aria-live="polite">
                    <strong class="d-block mb-1">&#10003; ¡Registro exitoso!</strong>
                    Tu cuenta se creó correctamente. Ya podés iniciar sesión.
                </div>
            <?php endif; ?>

            <form action="../controllers/procesarLogin.php" method="POST" class="d-flex flex-column gap-3">
                <div>
                    <label for="usuario" class="form-label fw-semibold">Usuario o correo electrónico</label>
                    <input
                        type="text"
                        class="form-control"
                        id="usuario"
                        name="usuario"
                        autocomplete="username"
                        required
                    >
                </div>

                <div>
                    <label for="password" class="form-label fw-semibold">Contraseña</label>
                    <input
                        type="password"
                        class="form-control"
                        id="password"
                        name="password"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-primary bg-success py-2">Iniciar sesión</button>

                <p class="text-center mb-0 mt-2" >
                    ¿No tenés una cuenta?
                    <a href="index.php?views=loginRegistro/registro">Registrate</a>
                </p>
            </form>

        </div>
    </div>
</div>
