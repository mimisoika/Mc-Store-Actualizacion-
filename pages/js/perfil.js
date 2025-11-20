const elementosTooltip = document.querySelectorAll('[data-bs-toggle="tooltip"]');
const listaTooltips = [...elementosTooltip].map(elemento => new bootstrap.Tooltip(elemento));

const pestañas = document.querySelectorAll('#tablas_perfil .nav-link');
pestañas.forEach(pestaña => {
    pestaña.addEventListener('click', function() {
        pestañas.forEach(p => {
            p.classList.remove('active', 'bg-white', 'text-primary');
            p.classList.add('text-white');
        });
        
        this.classList.add('active', 'bg-white', 'text-primary');
        this.classList.remove('text-white');
    });
});

const botonCerrarSesion = document.querySelector('button[name="cerrar_sesion"]');
botonCerrarSesion.addEventListener('click', function(evento) {
    if (!confirm('¿Estás seguro de que deseas cerrar sesión?')) {
        evento.preventDefault();
    }
});


const btnEditar = document.getElementById('btnEditar');
const btnGuardar = document.getElementById('btnGuardar');
const btnCancelar = document.getElementById('btnCancelar');
const camposEditables = ['inputNombre', 'inputApellidoPaterno', 'inputApellidoMaterno', 'inputTelefono'];
let valoresOriginales = {};

if (btnEditar) {
    btnEditar.addEventListener('click', function() {
        // Guardar valores originales
        camposEditables.forEach(id => {
            const campo = document.getElementById(id);
            valoresOriginales[id] = campo.value;
            campo.removeAttribute('readonly');
            campo.classList.add('border-primary');
        });
        
        // Mostrar/ocultar botones
        btnEditar.classList.add('d-none');
        btnGuardar.classList.remove('d-none');
        btnCancelar.classList.remove('d-none');
    });
}

if (btnCancelar) {
    btnCancelar.addEventListener('click', function() {
        camposEditables.forEach(id => {
            const campo = document.getElementById(id);
            campo.value = valoresOriginales[id];
            campo.setAttribute('readonly', true);
            campo.classList.remove('border-primary');
        });
        
        btnEditar.classList.remove('d-none');
        btnGuardar.classList.add('d-none');
        btnCancelar.classList.add('d-none');
    });
}

// Función para refrescar los productos favoritos
async function refrescarFavoritos() {
    try {
        const response = await fetch('get_favoritos.php');
        const data = await response.json();
        
        if (data.success) {
            const tabFavoritos = document.getElementById('favoritos');
            if (tabFavoritos) {
                // Actualizar el contenido de la pestaña de favoritos
                const cardBody = tabFavoritos.querySelector('.card-body');
                
                if (data.favoritos.length === 0) {
                    cardBody.innerHTML = `
                        <div class="text-center py-5">
                            <i class="fas fa-heart fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">No tienes productos favoritos</h5>
                            <p class="text-muted">Agrega productos a tu lista de favoritos para verlos aquí</p>
                            <a href="catalogo.php" class="btn btn-primary">
                                <i class="fas fa-heart me-2"></i>Explorar Productos
                            </a>
                        </div>
                    `;
                } else {
                    let html = '<div class="row g-4">';
                    data.favoritos.forEach(producto => {
                        const imagen = producto.imagen || 'img_productos/producto-default.jpg';
                        const descripcion = producto.descripcion.substring(0, 100) + '...';
                        html += `
                            <div class="col-lg-4 col-md-6">
                                <div class="card h-100 shadow-sm">
                                    <div class="position-relative overflow-hidden" style="height: 200px;">
                                        <img src="${imagen}" class="card-img-top" alt="${producto.nombre}" style="height: 100%; object-fit: cover;">
                                        <div class="position-absolute top-0 end-0 p-2">
                                            <button class="btn btn-sm btn-danger" onclick="toggleFavorito(${producto.id}, this)" title="Quitar de favoritos">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">${producto.nombre}</h5>
                                        <p class="card-text text-muted flex-grow-1">${descripcion}</p>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <span class="h6 text-primary mb-0">$${parseFloat(producto.precio).toFixed(2)}</span>
                                            <a href="producto.php?id=${producto.id}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye me-1"></i>Ver
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    html += '</div>';
                    cardBody.innerHTML = html;
                }
            }
        }
    } catch (error) {
        console.error('Error al refrescar favoritos:', error);
    }
}

// Escuchar cambios en el localStorage cuando se agregan/eliminan favoritos desde otras pestañas
window.addEventListener('storage', function(e) {
    if (e.key === 'favoritos_actualizado') {
        refrescarFavoritos();
    }
});

// Interceptar la función toggleFavorito para refrescar después
const originalToggleFavorito = window.toggleFavorito;
if (originalToggleFavorito) {
    window.toggleFavorito = function(productId, element) {
        originalToggleFavorito(productId, element);
        // Refrescar después de un pequeño delay para asegurar que se actualice en BD
        setTimeout(refrescarFavoritos, 500);
    };
}
