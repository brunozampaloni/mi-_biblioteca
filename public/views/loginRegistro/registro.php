<?php
$error = $_GET["error"] ?? "";

$mensajes = [
    "campos" => "Completá todos los campos antes de continuar.",
    "nombre" => "El nombre o apellido ingresado no es válido.",
    "usuario" => "El nombre de usuario debe tener entre 3 y 30 caracteres y solo puede contener letras, números, puntos, guiones y guiones bajos.",
    "email" => "El correo electrónico ingresado no tiene un formato válido.",
    "password" => "La contraseña debe tener al menos 8 caracteres.",
    "contrasenas" => "Las contraseñas ingresadas no coinciden.",
    "usuario_duplicado" => "Ese nombre de usuario ya está registrado. Elegí otro.",
    "email_duplicado" => "Ese correo electrónico ya está registrado.",
    "registro" => "No se pudo completar el registro. Intentá nuevamente."
];

$mensaje = $mensajes[$error] ?? "";
?>

<div class="container py-5">
    <div class="card shadow-sm border-0 mx-auto" style="max-width: 480px;">
        <div class="card-body p-4">

            <h1 class="h3 text-center mb-2">Crear una cuenta</h1>

            <p class="text-center text-muted mb-4">
                Registrate para comenzar a usar tu biblioteca personal.
            </p>

            <?php if ($mensaje !== ""): ?>
                <div class="alert alert-danger rounded-3" role="alert" aria-live="polite">
                    <strong class="d-block mb-1">&#9888; No se pudo completar el registro</strong>
                    <?= htmlspecialchars($mensaje, ENT_QUOTES, "UTF-8") ?>
                </div>
            <?php endif; ?>

            <form action="../controllers/procesarRegistro.php" method="POST" class="d-flex flex-column gap-3">
                <div>
                    <label for="nombre" class="form-label fw-semibold">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" autocomplete="given-name" maxlength="100" required>
                </div>

                <div>
                    <label for="apellido" class="form-label fw-semibold">Apellido</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" autocomplete="family-name" maxlength="100" required>
                </div>

                <div>
                    <label for="nombre_usuario" class="form-label fw-semibold">Nombre de usuario</label>
                    <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" autocomplete="username" minlength="3" maxlength="30" required>
                    <div class="form-text">Entre 3 y 30 caracteres. Podés usar letras, números, puntos, guiones y guiones bajos.</div>
                </div>

                <div>
                    <label for="email" class="form-label fw-semibold">Correo electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="ejemplo@correo.com" autocomplete="email" maxlength="254" required>
                </div>

                <div>
                    <label for="password" class="form-label fw-semibold">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" autocomplete="new-password" minlength="8" required>
                    <div class="form-text">Debe tener al menos 8 caracteres.</div>
                </div>

                <div>
                    <label for="confirmacion_password" class="form-label fw-semibold">Confirmar contraseña</label>
                    <input type="password" class="form-control" id="confirmacion_password" name="confirmacion_password" autocomplete="new-password" minlength="8" required>
                </div>

                <button type="submit" class="btn btn-primary bg-success py-2">Crear cuenta</button>

                <p class="text-center mb-0 mt-2">
                    ¿Ya tenés una cuenta?
                    <a href="index.php?views=loginRegistro/login">Iniciá sesión</a>
                </p>
            </form>

        </div>
    </div>
</div>
