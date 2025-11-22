<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'functions/f_header.php';
require_once 'admin/functions/f_configuracion.php';

$config = obtenerConfiguracion();
?>
<?php
// Base URL dinámico para construir rutas que funcionen tanto desde la raíz del proyecto
// como desde subdirectorios (evita usar ../ en los href que causan 404)
$baseDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
if ($baseDir === '/' || $baseDir === '.') {
    $baseDir = '';
}

function url_path($path) {
    global $baseDir;
    $path = ltrim($path, '/');
    return $baseDir ? $baseDir . '/' . $path : $path;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light sticky-top" style="background-color: <?php echo htmlspecialchars($config['color_encabezado']); ?>; color: <?php echo htmlspecialchars($config['color_texto']); ?>; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
    <div class="container-fluid px-4">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="../pages/img/logo-mcstore.png" alt="<?php echo htmlspecialchars($config['nombre_sitio']); ?>" width="40" height="40" class="me-2 rounded-circle">
            <span class="fw-bold fs-4" style="color: <?php echo htmlspecialchars($config['color_primario']); ?>;"><?php echo htmlspecialchars($config['nombre_sitio']); ?></span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <div class="mx-auto d-none d-lg-block" style="max-width: 400px;">
                <form class="d-flex" action="pages/products.php" method="GET" role="search">
                    <div class="input-group">
                        <input class="form-control" type="search" name="search" placeholder="Buscar productos..." aria-label="Buscar">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo url_path('index.php#inicio'); ?>">
                        <i class="fas fa-home me-1"></i>Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo url_path('index.php#productos'); ?>">
                        <i class="fas fa-th-large me-1"></i>Productos Destacados
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo url_path('pages/catalogo.php'); ?>">
                        <i class="fas fa-th-large me-1"></i>Catalogo
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo url_path('index.php#acerca'); ?>">
                        <i class="fas fa-users me-1"></i>Nosotros
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo url_path('index.php#contacto'); ?>">
                        <i class="fas fa-envelope me-1"></i>Contacto
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link position-relative" href="<?php echo url_path('pages/carrito.php'); ?>">
                        <i class="fas fa-shopping-cart me-1"></i>
                        <span>Carrito</span>
                    </a>
                </li>
                
                <li class="nav-item d-lg-none mt-2">
                    <form class="d-flex" action="<?php echo url_path('pages/products.php'); ?>" method="GET" role="search">
                        <div class="input-group">
                            <input class="form-control" type="search" name="search" placeholder="Buscar productos..." aria-label="Buscar">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </li>

                <li class="nav-item dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle ms-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i>
                        <span class="d-none d-md-inline">Usuario</span>
                    </button>
                    <?php echo generarMenuUsuario(); ?>
                </li>
            </ul>
        </div>
    </div>
</nav>