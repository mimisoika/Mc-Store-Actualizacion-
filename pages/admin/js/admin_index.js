$(document).ready(function() {
    // Inicializar gráfica de pedidos
    crearGraficaPedidos();
    
    // Activar enlace del menú
    $('.menu-item[data-section]').on('click', function(e) {
    e.preventDefault();
    $('.menu-item').removeClass('active');
    $(this).addClass('active');

    const href = $(this).attr('href'); // o data-file
    $('.content').load(href, function(response, status) {
        if (status === 'error') {
            console.error('Error cargando', href);
        } else {
            console.log('Sección cargada:', href);
        }
    });
    });

    
    // Paginación de puntos
    $('.dot').on('click', function() {
        $('.dot').removeClass('active');
        $(this).addClass('active');
    });
    
    // Botones de paginación
    $('.pagination-btn').on('click', function() {
        const dots = $('.dot');
        const currentActive = dots.index(dots.filter('.active'));
        const isNext = $(this).index() === 1;
        
        let nextIndex = isNext ? currentActive + 1 : currentActive - 1;
        
        if (nextIndex >= dots.length) {
            nextIndex = 0;
        } else if (nextIndex < 0) {
            nextIndex = dots.length - 1;
        }
        
        dots.removeClass('active');
        dots.eq(nextIndex).addClass('active');
    });
    
    // Botones de acciones de tarjetas
    $('.action-btn').on('click', function() {
        const icon = $(this).find('i');
        const isEdit = icon.hasClass('bi-pencil');
        
        if (isEdit) {
            console.log('Editar categoría');
        } else {
            console.log('Ver detalles');
        }
    });
    
    // Búsqueda
    $('.search-btn').on('click', function() {
        const searchTerm = $('.search-input').val();
        if (searchTerm) {
            console.log('Buscar:', searchTerm);
        }
    });
    
    $('.search-input').on('keypress', function(e) {
        if (e.which === 13) {
            $('.search-btn').click();
        }
    });
});

// Función para crear la gráfica de pastel de pedidos
function crearGraficaPedidos() {
    const ctx = document.getElementById('pedidosChart');
    if (!ctx) return;
    
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Pendientes', 'Completados', 'En Proceso', 'Cancelados'],
            datasets: [{
                data: [45, 120, 80, 25],
                backgroundColor: [
                    '#0052cc',
                    '#28a745',
                    '#ffc107',
                    '#dc3545'
                ],
                borderColor: [
                    '#0052cc',
                    '#28a745',
                    '#ffc107',
                    '#dc3545'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 12,
                            family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                        },
                        color: '#333',
                        padding: 15
                    }
                }
            }
        }
    });
}
