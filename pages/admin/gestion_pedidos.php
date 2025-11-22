<?php
require_once '../functions/f_login.php';

// Verificar que el usuario sea admin
if (!estaLogueado() || obtenerUsuario()['rol'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/admin_style.css">
    <style>
        .main-content .content { padding: 24px; }
        .badge-pendiente { background-color: #ffc107; color: #000; }
        .badge-confirmado { background-color: #0d6efd; color: #fff; }
        .badge-preparando { background-color: #fd7e14; color: #fff; }
        .badge-en-camino { background-color: #17a2b8; color: #fff; }
        .badge-entregado { background-color: #28a745; color: #fff; }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <i class="bi bi-x"></i>
                </div>
                <h3>MC Store</h3>
            </div>
            
            <nav class="sidebar-menu">
                <a href="admin_index.php" class="menu-item">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
                <a href="gestion_de_productos.php" class="menu-item">
                    <i class="bi bi-box-seam"></i>
                    <span>Productos</span>
                </a>
                <a href="gestion_pedidos.php" class="menu-item active">
                    <i class="bi bi-clipboard-check"></i>
                    <span>Pedidos</span>
                </a>
                <a href="gestion_de_usuarios.php" class="menu-item">
                    <i class="bi bi-people-fill"></i>
                    <span>Usuarios</span>
                </a>
                <a href="gestion_catalogo.php" class="menu-item">
                    <i class="bi bi-tag"></i>
                    <span>Categorias</span>
                </a>
                <a href="configuracion.php" class="menu-item">
                    <i class="bi bi-gear"></i>
                    <span>Configuracion</span>
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <a href="../../index.php" class="menu-item">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Volver a Pagina Principal</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <header class="top-bar">
                <div class="search-container">
                    
                </div>
            </header>

            <!-- Content -->
            <div class="content">
                <div class="content-header d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-0"><i class="bi bi-clipboard-check"></i> Gestión de Pedidos</h2>
                        <p class="text-muted mb-0">Sistema de gestión de pedidos</p>
                    </div>
                </div>

                <!-- Filtros -->
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="bi bi-funnel"></i> Filtros</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="filtroUsuario" class="form-label">Usuario</label>
                                <input type="text" id="filtroUsuario" class="form-control" placeholder="Buscar por usuario...">
                            </div>
                            <div class="col-md-4">
                                <label for="filtroEstatus" class="form-label">Estatus</label>
                                <select id="filtroEstatus" class="form-select">
                                    <option value="">Todos los estados</option>
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Confirmado">Confirmado</option>
                                    <option value="Preparando">Preparando</option>
                                    <option value="En camino">En camino</option>
                                    <option value="Entregado">Entregado</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="filtroFecha" class="form-label">Fecha de pedido</label>
                                <input type="date" id="filtroFecha" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla de pedidos -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle" id="tablaPedidos">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Fecha <i class="bi bi-arrow-down-up"></i></th>
                                        <th>Usuario <i class="bi bi-arrow-down-up"></i></th>
                                        <th>Método Pago</th>
                                        <th>Total</th>
                                        <th>Estatus</th>
                                        <th>Detalles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Ejemplo de pedido -->
                                    <tr>
                                        <td>2025-10-11 10:2:23</td>
                                        <td>Maria Guadalupe</td>
                                        <td>Mercado Pago</td>
                                        <td>$1046.45</td>
                                        <td>
                                            <select class="form-select form-select-sm badge-pendiente" style="width: auto; min-width: 130px;">
                                                <option value="Pendiente" selected>Pendiente</option>
                                                <option value="Confirmado">Confirmado</option>
                                                <option value="Preparando">Preparando</option>
                                                <option value="En camino">En camino</option>
                                                <option value="Entregado">Entregado</option>
                                            </select>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#detallesPedidoModal" onclick="cargarDetallesPedido(1)">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Más pedidos se cargarían dinámicamente aquí -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal para ver detalles del pedido -->
    <div class="modal fade" id="detallesPedidoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-clipboard-check"></i> Detalles de pedido</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Información del pedido -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary"><i class="bi bi-info-circle"></i> Información del Pedido</h6>
                            <div class="bg-light p-3 rounded">
                                <p class="mb-2"><span class="fw-bold">Fecha:</span> <span id="detalleFecha">2025-10-11 10:2:23</span></p>
                                <p class="mb-2"><span class="fw-bold">Usuario:</span> <span id="detalleUsuario">Maria Guadalupe</span></p>
                                <p class="mb-2"><span class="fw-bold">Método de Pago:</span> <span id="detalleMetodoPago">Mercado Pago</span></p>
                                <p class="mb-0"><span class="fw-bold">Total:</span> <span id="detalleTotal" class="text-success fw-bold">$1046.45</span></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary"><i class="bi bi-geo-alt"></i> Dirección de entrega</h6>
                            <div class="bg-light p-3 rounded">
                                <p class="mb-2"><span class="fw-bold">Alias:</span> <span id="detalleAlias">Casa</span></p>
                                <p class="mb-2"><span class="fw-bold">Dirección:</span> <span id="detalleDireccion">Av. Insurgentes 123, Col. Condesa</span></p>
                                <p class="mb-2"><span class="fw-bold">Ciudad:</span> <span id="detalleCiudad">Loreto</span></p>
                                <p class="mb-0"><span class="fw-bold">CP:</span> <span id="detalleCP">236700</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Productos -->
                    <div class="mb-3">
                        <h6 class="fw-bold text-primary"><i class="bi bi-box-seam"></i> Productos</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>Producto</th>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="detalleProductos">
                                    <tr>
                                        <td>harina</td>
                                        <td class="text-center">4</td>
                                        <td class="text-end">$225</td>
                                    </tr>
                                    <!-- Más productos se cargarían dinámicamente aquí -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="js/admin_index.js"></script>
    <script>
        // Función para cargar los detalles de un pedido específico
        function cargarDetallesPedido(pedidoId) {
            // Aquí iría la lógica AJAX para cargar los datos del pedido desde el servidor
            // Por ahora solo muestra los datos de ejemplo que ya están en el modal
            console.log('[v0] Cargando detalles del pedido:', pedidoId);
        }

        // Evento para cambiar el estatus del pedido
        $(document).on('change', '#tablaPedidos select', function() {
            const nuevoEstatus = $(this).val();
            const select = $(this);
            
            // Remover todas las clases de badge
            select.removeClass('badge-pendiente badge-confirmado badge-preparando badge-en-camino badge-entregado');
            
            // Agregar la clase correspondiente al nuevo estatus
            switch(nuevoEstatus) {
                case 'Pendiente':
                    select.addClass('badge-pendiente');
                    break;
                case 'Confirmado':
                    select.addClass('badge-confirmado');
                    break;
                case 'Preparando':
                    select.addClass('badge-preparando');
                    break;
                case 'En camino':
                    select.addClass('badge-en-camino');
                    break;
                case 'Entregado':
                    select.addClass('badge-entregado');
                    break;
            }
            
            // Aquí iría la lógica AJAX para actualizar el estatus en el servidor
            console.log('[v0] Actualizando estatus del pedido a:', nuevoEstatus);
        });

        // Filtros
        $('#filtroUsuario, #filtroEstatus, #filtroFecha').on('change keyup', function() {
            // Aquí iría la lógica para filtrar la tabla
            console.log('[v0] Aplicando filtros...');
        });
    </script>
</body>
</html>
