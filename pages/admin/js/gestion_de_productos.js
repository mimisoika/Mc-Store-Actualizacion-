$(document).ready(function() {
    cargarProductos();
    cargarCategorias();
    
    // Event listeners
    $('#filtroCategoria, #filtroEstado').change(cargarProductos);
    $('#btnBuscar').click(cargarProductos);
    $('#filtroBusqueda').keypress(function(e) {
        if (e.which === 13) cargarProductos();
    });
    
    // Preview de imagen en agregar
    $('#imagen').change(function() {
        previewImagen(this, '#previewImagen', '#sinImagen');
    });
    
    // Preview de imagen en editar
    $('#editImagen').change(function() {
        previewImagen(this, '#editPreviewImagen');
    });
    
    // Formularios
    $('#formAgregarProducto').submit(function(e) {
        e.preventDefault();
        agregarProducto();
    });
    
    $('#formEditarProducto').submit(function(e) {
        e.preventDefault();
        actualizarProducto();
    });
});

function cargarProductos() {
    const filtroCategoria = $('#filtroCategoria').val();
    const filtroEstado = $('#filtroEstado').val();
    const busqueda = $('#filtroBusqueda').val();
    
    $.ajax({
        url: 'functions/f_agregar_productos.php',
        method: 'POST',
        data: {
            accion: 'obtener_productos',
            filtroCategoria: filtroCategoria,
            filtroEstado: filtroEstado,
            busqueda: busqueda
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                mostrarProductos(response.productos);
            } else {
                console.error('Error al cargar productos');
            }
        },
        error: function() {
            console.error('Error de conexión');
        }
    });
}

function cargarCategorias() {
    $.ajax({
        url: 'functions/f_agregar_productos.php',
        method: 'POST',
        data: { accion: 'obtener_categorias' },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                const categorias = response.categorias;
                let options = '<option value="todas">Todas las categorías</option>';
                categorias.forEach(cat => {
                    options += `<option value="${cat.nombre}">${cat.nombre}</option>`;
                });
                $('#filtroCategoria').html(options);
                
                // Para los selects de los modales
                let modalOptions = '<option value="">Seleccionar categoría</option>';
                categorias.forEach(cat => {
                    modalOptions += `<option value="${cat.nombre}">${cat.nombre}</option>`;
                });
                $('#categoria, #editCategoria').html(modalOptions);
            }
        }
    });
}

function mostrarProductos(productos) {
    const container = $('#productos-container');
    
    if (productos.length === 0) {
        container.html(`
            <div class="col-12 text-center py-5">
                <i class="bi bi-box-seam display-1 text-muted"></i>
                <h3 class="text-muted">No se encontraron productos</h3>
                <p class="text-muted">Intenta ajustar los filtros o agregar nuevos productos.</p>
            </div>
        `);
        return;
    }
    
    let html = '';
    productos.forEach(producto => {
        const estadoBadge = getEstadoBadge(producto.estado);
        const imagenSrc = producto.imagen ? `../../img_productos/${producto.imagen}` : 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==';
        
        html += `
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <img src="${imagenSrc}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="${producto.nombre}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">${producto.nombre}</h5>
                        <p class="card-text text-muted small">${producto.descripcion || 'Sin descripción'}</p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="h5 text-primary mb-0">$${parseFloat(producto.precio).toFixed(2)}</span>
                                ${estadoBadge}
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">Stock: ${producto.cantidad || 0}</small>
                                <small class="text-muted">${producto.categoria || 'Sin categoría'}</small>
                            </div>
                            <div class="btn-group w-100" role="group">
                                <button class="btn btn-outline-primary btn-sm" onclick="editarProducto(${producto.id})">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-outline-danger btn-sm" onclick="eliminarProducto(${producto.id}, '${producto.nombre}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    
    container.html(html);
}

function getEstadoBadge(estado) {
    const badges = {
        'disponible': '<span class="badge bg-success">Disponible</span>',
        'agotado': '<span class="badge bg-danger">Agotado</span>',
        'suspendido': '<span class="badge bg-secondary">Suspendido</span>',
        'poco_stock': '<span class="badge bg-warning">Poco Stock</span>'
    };
    return badges[estado] || '<span class="badge bg-secondary">Desconocido</span>';
}

function agregarProducto() {
    const formData = new FormData();
    formData.append('accion', 'agregar_producto');
    formData.append('nombre', $('#nombre').val());
    formData.append('precio', $('#precio').val());
    formData.append('categoria', $('#categoria').val());
    formData.append('estado', $('#estado').val());
    formData.append('descripcion', $('#descripcion').val());
    formData.append('cantidad', $('#cantidad').val() || 0);
    
    const imagen = $('#imagen')[0].files[0];
    if (imagen) {
        formData.append('imagen', imagen);
    }
    
    $.ajax({
        url: 'functions/f_agregar_productos.php',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#agregarProductoModal').modal('hide');
                $('#formAgregarProducto')[0].reset();
                $('#previewImagen').hide();
                $('#sinImagen').show();
                cargarProductos();
                alert('Producto agregado exitosamente');
            } else {
                alert('Error: ' + (response.mensaje || 'No se pudo agregar el producto'));
            }
        },
        error: function() {
            alert('Error de conexión');
        }
    });
}

function editarProducto(id) {
    $.ajax({
        url: 'functions/f_agregar_productos.php',
        method: 'POST',
        data: {
            accion: 'obtener_producto',
            id: id
        },
        dataType: 'json',
        success: function(response) {
            if (response.success && response.producto) {
                const p = response.producto;
                $('#editId').val(p.id);
                $('#editNombre').val(p.nombre);
                $('#editPrecio').val(p.precio);
                $('#editCategoria').val(p.categoria);
                $('#editEstado').val(p.estado);
                $('#editDescripcion').val(p.descripcion);
                $('#editCantidad').val(p.cantidad);
                
                if (p.imagen) {
                    $('#editPreviewImagen').attr('src', `../../img_productos/${p.imagen}`).show();
                } else {
                    $('#editPreviewImagen').hide();
                }
                
                $('#editarProductoModal').modal('show');
            }
        }
    });
}

function actualizarProducto() {
    const formData = new FormData();
    formData.append('accion', 'actualizar_producto');
    formData.append('id', $('#editId').val());
    formData.append('nombre', $('#editNombre').val());
    formData.append('precio', $('#editPrecio').val());
    formData.append('categoria', $('#editCategoria').val());
    formData.append('estado', $('#editEstado').val());
    formData.append('descripcion', $('#editDescripcion').val());
    formData.append('cantidad', $('#editCantidad').val() || 0);
    
    const imagen = $('#editImagen')[0].files[0];
    if (imagen) {
        formData.append('imagen', imagen);
    }
    
    $.ajax({
        url: 'functions/f_agregar_productos.php',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#editarProductoModal').modal('hide');
                cargarProductos();
                alert('Producto actualizado exitosamente');
            } else {
                alert('Error: ' + (response.mensaje || 'No se pudo actualizar el producto'));
            }
        },
        error: function() {
            alert('Error de conexión');
        }
    });
}

function eliminarProducto(id, nombre) {
    if (confirm(`¿Estás seguro de que deseas suspender el producto "${nombre}"?`)) {
        $.ajax({
            url: 'functions/f_agregar_productos.php',
            method: 'POST',
            data: {
                accion: 'eliminar_producto',
                id: id
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    cargarProductos();
                    alert('Producto suspendido exitosamente');
                } else {
                    alert('Error: ' + (response.mensaje || 'No se pudo suspender el producto'));
                }
            },
            error: function() {
                alert('Error de conexión');
            }
        });
    }
}

function previewImagen(input, imgSelector, noImgSelector) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            $(imgSelector).attr('src', e.target.result).show();
            if (noImgSelector) {
                $(noImgSelector).hide();
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}