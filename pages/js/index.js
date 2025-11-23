function agregarAlCarrito(productoId) {
    const informacion = new FormData();
    informacion.append('producto_id', productoId);
    
    fetch('pages/agregar_carrito.php', {
        method: 'POST',
        body: informacion
    })
}

// Inicialización mejorada del carrusel "heroCarousel"
document.addEventListener('DOMContentLoaded', function() {
    var carouselEl = document.querySelector('#heroCarousel');
    if (carouselEl && typeof bootstrap !== 'undefined') {
        new bootstrap.Carousel(carouselEl, {
            interval: 5000,
            pause: 'hover',
            touch: true,
            wrap: true
        });
    }
});