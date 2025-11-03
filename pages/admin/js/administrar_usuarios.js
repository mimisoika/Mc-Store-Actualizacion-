$(document).ready(function() {
    // Cargar usuarios al iniciar
    cargarUsuarios();
    
    // Event listeners
    $('#filtroEstado').change(function() {
        cargarUsuarios();
    });
    
    $('#btnBuscar').click(function() {
        cargarUsuarios();
    });
    
    $('#busqueda').keypress(function(e) {
        if (e.which == 13) { // Enter key
            cargarUsuarios();
        }
    });
    
    $('#btnGuardarCambios').click(function() {
        actualizarUsuario();
    });
});

function cargarUsuarios() {
    const filtroEstado = $('#filtroEstado').val();
    const busqueda = $('#busqueda').val();
    
    // Mostrar loading
    $('#loading').show();
    $('#tUsuarios').addClass('d-none');
    
    $.ajax({
        url: 'functions/f_gestion_de_usuarios.php',
        method: 'POST',
        data: {
            accion: 'obtener_usuarios',
            filtroEstado: filtroEstado,
            busqueda: busqueda
        },
        dataType: 'json',
        success: function(response) {
            $('#loading').hide();
            
            if (response.success) {
                mostrarUsuarios(response.usuarios);
            } else {
                console.error('Error al cargar usuarios');
            }
        },
        error: function(xhr, status, error) {
            $('#loading').hide();
            console.error('Error AJAX:', error);
            console.error('Response:', xhr.responseText);
        }
    });
}

function mostrarUsuarios(usuarios) {
    const tbody = $('#tUsuarios tbody');
    tbody.empty();
    
    if (usuarios.length === 0) {
        tbody.append(`
            <tr>
                <td colspan="7" class="text-center text-muted py-4">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    No se encontraron usuarios
                </td>
            </tr>
        `);
    } else {
        usuarios.forEach(function(usuario) {
            const estadoBadge = getEstadoBadge(usuario.estado);
            const rolBadge = getRolBadge(usuario.rol);
            const fila = `
                <tr>
                    <td>${usuario.id}</td>
                    <td>${usuario.nombre}</td>
                    <td>${usuario.email}</td>
                    <td>${estadoBadge}</td>
                    <td>${rolBadge}</td>
                    <td>${usuario.fecha_registro}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-info" onclick="verDetalleUsuario(${usuario.id})" title="Ver detalles">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning" onclick="editarUsuario(${usuario.id}, '${usuario.nombre}', '${usuario.email}', '${usuario.estado}', '${usuario.rol}')" title="Editar usuario">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-secondary" onclick="confirmarSuspender(${usuario.id}, '${usuario.nombre}')" title="Suspender usuario">
                                <i class="bi bi-pause-circle"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="confirmarEliminar(${usuario.id}, '${usuario.nombre}')" title="Desactivar usuario">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
            tbody.append(fila);
        });
    }
    
    $('#tUsuarios').removeClass('d-none');
}

function getEstadoBadge(estado) {
    switch(estado) {
        case 'activo':
            return '<span class="badge bg-success">Activo</span>';
        case 'inactivo':
            return '<span class="badge bg-warning">Inactivo</span>';
        case 'suspendido':
            return '<span class="badge bg-danger">Suspendido</span>';
        default:
            return '<span class="badge bg-secondary">Desconocido</span>';
    }
}

function getRolBadge(rol) {
    switch(rol) {
        case 'admin':
            return '<span class="badge bg-primary">Administrador</span>';
        case 'cliente':
            return '<span class="badge bg-secondary">Cliente</span>';
        default:
            return '<span class="badge bg-light text-dark">Desconocido</span>';
    }
}

function editarUsuario(id, nombre, email, estado, rol) {
    $('#usuarioId').val(id);
    $('#usuarioNombre').text(nombre);
    $('#usuarioEmail').text(email);
    $('#nuevoEstado').val(estado);
    $('#nuevoRol').val(rol);
    
    $('#editarModal').modal('show');
}

function actualizarUsuario() {
    const id = $('#usuarioId').val();
    const nuevoEstado = $('#nuevoEstado').val();
    const nuevoRol = $('#nuevoRol').val();
    
    $.ajax({
        url: 'functions/f_gestion_de_usuarios.php',
        method: 'POST',
        data: {
            accion: 'actualizar_usuario',
            id: id,
            nuevoEstado: nuevoEstado,
            nuevoRol: nuevoRol
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#editarModal').modal('hide');
                cargarUsuarios(); // Recargar la tabla
            } else {
                console.error(response.mensaje || 'Error al actualizar usuario');
            }
        },
        error: function() {
            console.error('Error de conexión al servidor');
        }
    });
}

function verDetalleUsuario(id) {
    $.ajax({
        url: 'functions/f_gestion_de_usuarios.php',
        method: 'POST',
        data: {
            accion: 'obtener_detalle',
            id: id
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                const usuario = response.usuario;
                $('#infoId').text(usuario.id);
                $('#infoNombre').text(usuario.nombre_completo);
                $('#infoEmail').text(usuario.email);
                $('#infoEstado').html(getEstadoBadge(usuario.estado));
                $('#infoRol').html(getRolBadge(usuario.rol));
                $('#infoFecha').text(usuario.fecha_registro);
                $('#infoTelefono').text(usuario.telefono || 'No disponible');
                
                $('#infoModal').modal('show');
            } else {
                console.error('Error al obtener detalles del usuario');
            }
        },
        error: function() {
            console.error('Error de conexión al servidor');
        }
    });
}

function confirmarSuspender(id, nombre) {
    if (confirm(`¿Estás seguro de que quieres suspender al usuario "${nombre}"?`)) {
        suspenderUsuario(id);
    }
}

function suspenderUsuario(id) {
    $.ajax({
        url: 'functions/f_gestion_de_usuarios.php',
        method: 'POST',
        data: {
            accion: 'suspender_usuario',
            id: id
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                cargarUsuarios(); // Recargar la lista
            } else {
                console.error(response.mensaje || 'Error al suspender usuario');
            }
        },
        error: function() {
            console.error('Error de conexión al servidor');
        }
    });
}

function confirmarEliminar(id, nombre) {
    if (confirm(`¿Estás seguro de que quieres desactivar al usuario "${nombre}"?`)) {
        eliminarUsuario(id);
    }
}

function eliminarUsuario(id) {
    $.ajax({
        url: 'functions/f_gestion_de_usuarios.php',
        method: 'POST',
        data: {
            accion: 'eliminar_usuario',
            id: id
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                cargarUsuarios(); // Recargar la tabla
            } else {
                console.error(response.mensaje || 'Error al eliminar usuario');
            }
        },
        error: function() {
            console.error('Error de conexión al servidor');
        }
    });
}