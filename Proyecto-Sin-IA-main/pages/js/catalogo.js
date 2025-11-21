function agregarAlCarrito(productoId) {
    const informacion = new FormData();
    informacion.append('producto_id', productoId);
    informacion.append('cantidad', 1);
    
    fetch('agregar_carrito_catalogo.php', {
        method: 'POST',
        body: informacion
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mostrar mensaje de éxito
            mostrarMensaje('Producto agregado al carrito exitosamente', 'success');
        } else {
            // Mostrar mensaje de error
            mostrarMensaje(data.message || 'Error al agregar producto', 'error');
            
            // Si no está logueado, redirigir al login
            if (data.message && data.message.includes('iniciar sesión')) {
                setTimeout(() => {
                    window.location.href = 'login.php';
                }, 2000);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarMensaje('Error de conexión', 'error');
    });
}

function mostrarMensaje(mensaje, tipo) {
    // Crear elemento de alerta
    const alerta = document.createElement('div');
    alerta.className = `alert alert-${tipo === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    alerta.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    
    alerta.innerHTML = `
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Agregar al body
    document.body.appendChild(alerta);
    
    // Remover automáticamente después de 5 segundos
    setTimeout(() => {
        if (alerta.parentNode) {
            alerta.remove();
        }
    }, 5000);
}

// Opcional: Agregar funcionalidad para cambiar cantidad
document.addEventListener('DOMContentLoaded', function() {
    // Aquí puedes agregar más funcionalidades como:
    // - Búsqueda en tiempo real
    // - Filtros adicionales
    // - Vista de detalles del producto
});