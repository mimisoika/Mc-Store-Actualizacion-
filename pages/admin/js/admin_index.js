$(document).ready(function() {
    cargarEstadisticas();
});

function cargarEstadisticas() {
    // Aquí puedes agregar llamadas AJAX para cargar estadísticas reales
    $('#totalUsuarios').text('0');
    $('#totalProductos').text('0');
    $('#totalPedidos').text('0');
    $('#ventasHoy').text('$0.00');
}

function generarReporte() {
    alert('Funcionalidad de reportes en desarrollo');
}