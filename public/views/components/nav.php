<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
    <div class="container">


        <a class="navbar-brand fw-bold" href="index.php">
            <i class="bi bi-book-half"></i> Mi Biblioteca
        </a>


        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>

        </button>

        





        <?php if (isset($_SESSION["usuario_id"])): ?>

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav me-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="index.php?views=dashboard">
                            <i class="bi bi-house-door-fill me-1"></i>
                            Mi biblioteca
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="index.php?views=busqueda">
                            <i class="bi bi-search me-1"></i>
                            Buscar libros
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="index.php?views=historial">
                            <i class="bi bi-clock-history me-1"></i>
                            Historial de lectura
                        </a>
                    </li>

                </ul>

                <a href="/mi_biblioteca/controllers/cerrarSesion.php"
                class="btn btn-danger">
                    <i class="bi bi-box-arrow-right me-1"></i>
                    Cerrar sesión
                </a>

            </div>

        <?php else: ?>


        <?php endif; ?>


        </div>

    </div>
</nav>