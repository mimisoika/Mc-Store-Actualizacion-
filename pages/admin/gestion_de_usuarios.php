<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - Panel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body class="bg-light">
    <?php
    require_once '../functions/f_login.php';

    // Verificar que el usuario sea admin
    if (!estaLogueado() || obtenerUsuario()['rol'] !== 'admin') {
        header('Location: ../login.php');
        exit();
    }
    ?>

    <div class="bg-primary text-white py-5 mb-4">
        <div class="container">
            <!-- Botón de regreso en el header -->
            <div class="row align-items-center">
                <div class="col-auto">
                    <a href="admin_index.php" class="btn btn-outline-light">
                        <i class="bi bi-arrow-left"></i> Volver al Panel
                    </a>
                </div>
                <div class="col text-center">
                    <h1 class="display-4 mb-0">
                        <i class="bi bi-people-fill"></i> Gestión de Usuarios
                    </h1>
                    <p class="lead mb-0">Sistema de gestión de usuarios</p>
                </div>
                <div class="col-auto">
                    <!-- Espacio para balance visual -->
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Filtros -->
        <div class="bg-white p-3 rounded mb-3 shadow-sm">
            <div class="row">
                <div class="col-md-6">
                    <label for="filtroEstado" class="form-label fw-bold">Filtrar por estado:</label>
                    <select id="filtroEstado" class="form-select">
                        <option value="todos">Todos los usuarios</option>
                        <option value="activo">Activos</option>
                        <option value="inactivo">Inactivos</option>
                        <option value="suspendido">Suspendidos</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="busqueda" class="form-label fw-bold">Buscar por nombre o email:</label>
                    <div class="input-group">
                        <input type="text" id="busqueda" class="form-control" placeholder="Buscar usuario...">
                        <button id="btnBuscar" class="btn btn-primary">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resultados -->
        <div id="resultado" class="bg-white shadow rounded p-3">
            <div class="table-responsive">
                <table id="tUsuarios" class="table table-bordered table-hover d-none">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>Email</th>
                            <th>Estado</th>
                            <th>Rol</th>
                            <th>Fecha de Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal para editar usuario -->
    <div class="modal fade" id="editarModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Editar Usuario</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="usuarioId">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre:</label>
                        <p id="usuarioNombre" class="bg-light p-2 rounded"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email:</label>
                        <p id="usuarioEmail" class="bg-light p-2 rounded"></p>
                    </div>
                    <div class="mb-3">
                        <label for="nuevoEstado" class="form-label fw-bold">Estado:</label>
                        <select id="nuevoEstado" class="form-select">
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                            <option value="suspendido">Suspendido</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nuevoRol" class="form-label fw-bold">Rol:</label>
                        <select id="nuevoRol" class="form-select">
                            <option value="cliente">Cliente</option>
                            <option value="admin">Administrador</option>
                        </select>
                        <div class="form-text">
                            <small>
                                <span class="fw-bold">Cliente:</span> Usuario normal del sistema<br>
                                <span class="fw-bold">Administrador:</span> Acceso completo al panel de administración
                            </small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </button>
                    <button type="button" id="btnGuardarCambios" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para ver información del usuario -->
    <div class="modal fade" id="infoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">Información del Usuario</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold">Datos Personales</h6>
                            <p><span class="fw-bold">ID:</span> <span id="infoId"></span></p>
                            <p><span class="fw-bold">Nombre:</span> <span id="infoNombre"></span></p>
                            <p><span class="fw-bold">Email:</span> <span id="infoEmail"></span></p>
                            <p><span class="fw-bold">Estado:</span> <span id="infoEstado"></span></p>
                            <p><span class="fw-bold">Rol:</span> <span id="infoRol"></span></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold">Información del Sistema</h6>
                            <p><span class="fw-bold">Fecha de Registro:</span> <span id="infoFecha"></span></p>
                            <p><span class="fw-bold">Teléfono:</span> <span id="infoTelefono">No disponible</span></p>
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

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/administrar_usuarios.js"></script>
</body>

</html>