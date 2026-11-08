
<?php

session_start();

// Eliminar los datos de la sesión
$_SESSION = [];

// Destruir la sesión
session_destroy();

header("Location: ../public/index.php?views=loginRegistro/login");
exit;
