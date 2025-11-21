function agregarAlCarrito(productoId) {
    const informacion = new FormData();
    informacion.append('producto_id', productoId);
    
    fetch('pages/agregar_carrito.php', {
        method: 'POST',
        body: informacion
    })
}