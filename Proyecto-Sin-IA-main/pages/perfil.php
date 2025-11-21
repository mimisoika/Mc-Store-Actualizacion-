<?php 
include '../php/database.php';
include 'functions/f_perfil.php';

// Iniciar sesión y verificar autenticación
iniciarSesionSegura();

// Verificar si el usuario está logueado
if (!estaLogueado()) {
    header('Location: login.php');
    exit();
}

// Obtener datos del usuario
$usuario_id = $_SESSION['usuario_id'];
$datosUsuario = obtenerDatosCompletos($usuario_id);
$pedidos = obtenerPedidosUsuario($usuario_id);
$direcciones = obtenerDireccionesUsuario($usuario_id);

// Manejar actualización de datos
$resultadoActualizacion = manejarActualizacionDatos($usuario_id);
if ($resultadoActualizacion['exito']) {
    $mensaje = $resultadoActualizacion['mensaje'];
    $datosUsuario = $resultadoActualizacion['datos'];
} elseif (!empty($resultadoActualizacion['mensaje'])) {
    $error = $resultadoActualizacion['mensaje'];
}

if (isset($_POST['cerrar_sesion'])) {
    cerrarSesion();
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mi Perfil - MC Store</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <?php include 'header.php'; ?>

    <?php if (isset($mensaje)): ?>
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($mensaje) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if (isset($error)): ?>
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i><?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>

    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-2 text-center">
                                <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="fas fa-user fs-1 text-white"></i>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h2 class="mb-1">
                                    <?php echo htmlspecialchars($datosUsuario['nombre'] . ' ' . $datosUsuario['apellido_paterno']); ?>
                                </h2>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-envelope me-2"></i><?php echo htmlspecialchars($datosUsuario['email']); ?>
                                </p>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-calendar me-2"></i>Miembro desde <?php echo date('M Y', strtotime($datosUsuario['fecha_creacion'])); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <!-- Sidebar de navegación -->
            <div class="col-lg-3 mb-4">
                <div class="card bg-primary text-white">
                    <div class="card-body p-4">
                        <h5 class="mb-4 text-center">
                            <i class="fas fa-user-cog me-2"></i>Mi Perfil
                        </h5>
                        <ul class="nav nav-pills flex-column" id="tablas_perfil">
                            <li class="nav-item mb-2">
                                <a class="nav-link active bg-white text-primary" data-bs-toggle="pill" href="#datos">
                                    <i class="fas fa-user me-2"></i>Datos Personales
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link text-white" data-bs-toggle="pill" href="#direcciones">
                                    <i class="fas fa-map-marker-alt me-2"></i>Direcciones
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link text-white" data-bs-toggle="pill" href="#pedidos">
                                    <i class="fas fa-shopping-bag me-2"></i>Mis Pedidos
                                </a>
                            </li>
                        </ul>
                        <hr class="my-4">
                        <form method="POST" class="d-grid">
                            <button class="btn btn-outline-light" type="submit" name="cerrar_sesion">
                                <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Contenido principal -->
            <div class="col-lg-9">
                <div class="tab-content">
                    <!-- Datos Personales -->
                    <div class="tab-pane fade show active" id="datos">
                        <div class="card shadow">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-user me-2"></i>Datos Personales
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <form method="POST" id="formDatos">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Nombre</label>
                                            <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($datosUsuario['nombre']); ?>" readonly id="inputNombre">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Apellido Paterno</label>
                                            <input type="text" name="apellido_paterno" class="form-control" value="<?php echo htmlspecialchars($datosUsuario['apellido_paterno']); ?>" readonly id="inputApellidoPaterno">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Apellido Materno</label>
                                            <input type="text" name="apellido_materno" class="form-control" value="<?php echo htmlspecialchars($datosUsuario['apellido_materno']); ?>" readonly id="inputApellidoMaterno">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Email</label>
                                            <input type="email" class="form-control" value="<?php echo htmlspecialchars($datosUsuario['email']); ?>" readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Teléfono</label>
                                            <input type="text" name="telefono" class="form-control" value="<?php echo htmlspecialchars($datosUsuario['telefono']); ?>" readonly id="inputTelefono">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Fecha de Registro</label>
                                            <input type="text" class="form-control" value="<?php echo date('d/m/Y', strtotime($datosUsuario['fecha_creacion'])); ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-primary" id="btnEditar">
                                            <i class="fas fa-edit me-2"></i>Editar Información
                                        </button>
                                        <button type="submit" name="actualizar_datos" class="btn btn-success d-none" id="btnGuardar">
                                            <i class="fas fa-save me-2"></i>Guardar Cambios
                                        </button>
                                        <button type="button" class="btn btn-secondary d-none" id="btnCancelar">
                                            <i class="fas fa-times me-2"></i>Cancelar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Direcciones -->
                    <div class="tab-pane fade" id="direcciones">
                        <div class="card shadow">
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-map-marker-alt me-2"></i>Mis Direcciones
                                </h5>
                                <button class="btn btn-light btn-sm">
                                    <i class="fas fa-plus me-1"></i>Agregar
                                </button>
                            </div>
                            <div class="card-body p-4">
                                <?php if (empty($direcciones)): ?>
                                    <div class="text-center py-5">
                                        <i class="fas fa-map-marker-alt fs-1 text-muted mb-3"></i>
                                        <h5 class="text-muted">No tienes direcciones registradas</h5>
                                        <p class="text-muted">Agrega tu primera dirección para realizar pedidos</p>
                                        <button class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Agregar Dirección
                                        </button>
                                    </div>
                                <?php else: ?>
                                    <div class="row">
                                        <?php foreach ($direcciones as $direccion): ?>
                                            <div class="col-md-6 mb-3">
                                                <div class="card border">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                            <h6 class="card-title mb-0"><?php echo htmlspecialchars($direccion['alias']); ?></h6>
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                                                                    <i class="fas fa-ellipsis-v"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Editar</a></li>
                                                                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Eliminar</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <p class="card-text text-muted mb-1">
                                                            <i class="fas fa-map-marker-alt me-1"></i>
                                                            <?php echo htmlspecialchars($direccion['direccion']); ?>
                                                        </p>
                                                        <p class="card-text text-muted mb-0">
                                                            <i class="fas fa-city me-1"></i>
                                                            <?php echo htmlspecialchars($direccion['ciudad'] . ', ' . $direccion['estado']); ?>
                                                        </p>
                                                        <p class="card-text text-muted">
                                                            <i class="fas fa-mail-bulk me-1"></i>
                                                            <?php echo htmlspecialchars($direccion['codigo_postal']); ?>
                                                        </p>
                                                        <?php if ($direccion['es_principal']): ?>
                                                            <span class="badge bg-success">Principal</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Pedidos -->
                    <div class="tab-pane fade" id="pedidos">
                        <div class="card shadow">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-shopping-bag me-2"></i>Historial de Pedidos
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <?php if (empty($pedidos)): ?>
                                    <div class="text-center py-5">
                                        <i class="fas fa-shopping-bag fs-1 text-muted mb-3"></i>
                                        <h5 class="text-muted">No tienes pedidos realizados</h5>
                                        <p class="text-muted">Explora nuestros productos y realiza tu primer pedido</p>
                                        <a href="../index.php" class="btn btn-primary">
                                            <i class="fas fa-shopping-cart me-2"></i>Ir a Comprar
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Pedido #</th>
                                                    <th>Fecha</th>
                                                    <th>Total</th>
                                                    <th>Estado</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($pedidos as $pedido): ?>
                                                    <tr>
                                                        <td class="fw-bold">#<?php echo $pedido['id']; ?></td>
                                                        <td><?php echo date('d/m/Y', strtotime($pedido['fecha_pedido'])); ?></td>
                                                        <td class="fw-bold text-success">$<?php echo number_format($pedido['total'], 2); ?></td>
                                                        <td>
                                                            <?php echo generarBadgeEstado($pedido['estado']); ?>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Ver detalles">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                            <?php if ($pedido['estado'] == 'pendiente'): ?>
                                                                <button class="btn btn-sm btn-outline-danger ms-1" data-bs-toggle="tooltip" title="Cancelar">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/perfil.js"></script>
</body>
</html>