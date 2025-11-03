<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Header -->
    <div class="bg-primary text-white py-5 mb-4">
        <div class="container">
            <div class="text-center">
                <h1 class="display-4 mb-0">
                    <i class="bi bi-shield-lock"></i> Panel de Administración
                </h1>
                <p class="lead mb-0">Sistema de gestión administrativa</p>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-people-fill text-primary" style="font-size: 3rem;"></i>
                        <h4 class="card-title mt-3">Gestión de Usuarios</h4>
                        <p class="card-text">Administra usuarios registrados, estados de cuenta y permisos del sistema.</p>
                        <a href="gestion_de_usuarios.php" class="btn btn-primary">
                            <i class="bi bi-arrow-right"></i> Ir a Usuarios
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-box-seam text-success" style="font-size: 3rem;"></i>
                        <h4 class="card-title mt-3">Gestión de Productos</h4>
                        <p class="card-text">Administra el catálogo de productos, precios, stock y categorías.</p>
                        <a href="gestions_de_productos.php" class="btn btn-success">
                            <i class="bi bi-arrow-right"></i> Ir a Productos
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Botón para regresar a la página principal -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="../../index.php" class="btn btn-outline-secondary btn-lg">
                    <i class="bi bi-house-door"></i> Regresar a la Página Principal
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="js/admin_index.js"></script>
</body>
</html>