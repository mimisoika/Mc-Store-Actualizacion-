<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MC Store - Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/admin_style.css">
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
                <a href="admin_index.php" class="menu-item active">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
                <a href="gestions_de_productos.php" class="menu-item">
                    <i class="bi bi-box-seam"></i>
                    <span>Productos</span>
                </a>
                <a href="gestion_de_pedidos.php" class="menu-item">
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
                    <input type="text" class="search-input" placeholder="Buscar ...">
                    <button class="search-btn"><i class="bi bi-search"></i></button>
                </div>
                <div class="top-bar-right">
                    <select class="region-select">
                        <option>Pancho</option>
                    </select>
                </div>
            </header>
            
            <!-- Content -->
            <div class="content">
                <div class="content-header mb-4">
                    <h2><i class="bi bi-speedometer2"></i> Dashboard</h2>
                    <p class="text-muted">Resumen general de tu tienda</p>
                </div>
                
                <!-- First Row: Best Selling Product, Profit Margin, Number of Orders -->
                <div class="row g-3 mb-4">
                    <!-- Best Selling Product -->
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white border-0 pb-0">
                                <h6 class="mb-0 text-center">Producto mas vendido</h6>
                            </div>
                            <div class="card-body text-center py-4">
                                <img src="https://magernet.alimentosmager.com/web/image/product.template/813/image_1024?unique=384a4af" alt="Producto" class="mb-3" style="height: 120px; width: auto; object-fit: contain;">
                                <div class="mt-2">
                                    <strong class="d-block">Precio</strong>
                                    <h5 class="text-primary mb-0">$45.00</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Profit Margin Card -->
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white border-0 pb-0">
                                <h6 class="mb-0 text-center">Margen de ganancias</h6>
                            </div>
                            <div class="card-body d-flex align-items-center justify-content-center py-4">
                                <h1 class="display-1 fw-bold mb-0">19%</h1>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Total Orders Card -->
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white border-0 pb-0">
                                <h6 class="mb-0 text-center">Numeros de pedidos</h6>
                            </div>
                            <div class="card-body d-flex align-items-center justify-content-center py-4">
                                <h1 class="display-1 fw-bold mb-0">2481</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Second Row: Sales by Category and Product Alerts -->
                <div class="row g-3 mb-4">
                    <!-- Sales by Category -->
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white border-0">
                                <h6 class="mb-0 text-center">Ventas por categoria</h6>
                            </div>
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <div style="position: relative; width: 100%; max-width: 280px; height: 280px;">
                                    <canvas id="categoryChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product Alerts -->
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white border-0">
                                <h6 class="mb-0 text-center">Alerta de productos</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nom_Producto</th>
                                            <th class="text-end">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Nom_Producto</td>
                                            <td class="text-end"><span class="badge bg-warning text-dark">Stock Bajo</span></td>
                                        </tr>
                                        <tr>
                                            <td>Nom_Producto</td>
                                            <td class="text-end"><span class="badge bg-warning text-dark">Stock Bajo</span></td>
                                        </tr>
                                        <tr>
                                            <td>Nom_Producto</td>
                                            <td class="text-end"><span class="badge bg-danger">Agotado</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Monthly Sales Chart -->
                <div class="row">
                    <div class="col-12">
                        <!-- Enhanced design for monthly sales section with gradient header and statistics -->
                        <div class="card shadow-sm border-0 overflow-hidden">
                            <div class="card-header border-0" style="background: linear-gradient(135deg, #ff7f50 0%, #ff6347 100%); color: white;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0"><i class="bi bi-graph-up-arrow me-2"></i>Ventas del mes</h5>
                                    <div class="d-flex gap-3">
                                        <div class="text-end">
                                            <small class="opacity-75 d-block">Total</small>
                                            <strong>$55,000</strong>
                                        </div>
                                        <div class="text-end">
                                            <small class="opacity-75 d-block">Promedio</small>
                                            <strong>$13,750</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body bg-light" style="padding: 2rem;">
                                <div style="position: relative; height: 350px; background: white; border-radius: 8px; padding: 1rem; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                    <canvas id="salesChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <!-- Added inline JavaScript for charts -->
    <script>
        // Category Sales Chart (Pie Chart)
        const categoryCtx = document.getElementById('categoryChart');
        if (categoryCtx) {
            new Chart(categoryCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Bebidas', 'Snacks', 'Dulces', 'Otros'],
                    datasets: [{
                        data: [25, 30, 25, 20],
                        backgroundColor: [
                            '#6c757d',
                            '#495057',
                            '#343a40',
                            '#212529'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.parsed + '%';
                                }
                            }
                        }
                    }
                },
                plugins: [{
                    beforeDraw: function(chart) {
                        const width = chart.width;
                        const height = chart.height;
                        const ctx = chart.ctx;
                        ctx.restore();
                        const fontSize = (height / 114).toFixed(2);
                        ctx.font = fontSize + "em sans-serif";
                        ctx.textBaseline = "middle";
                        const text = "25%";
                        const textX = Math.round((width - ctx.measureText(text).width) / 2);
                        const textY = height / 2;
                        ctx.fillText(text, textX, textY);
                        ctx.save();
                    }
                }]
            });
        }

        // Monthly Sales Chart (Area Chart)
        const salesCtx = document.getElementById('salesChart');
        if (salesCtx) {
            const gradient = salesCtx.getContext('2d').createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(255, 127, 80, 0.8)');
            gradient.addColorStop(0.5, 'rgba(255, 127, 80, 0.4)');
            gradient.addColorStop(1, 'rgba(255, 127, 80, 0.1)');
            
            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4'],
                    datasets: [{
                        label: 'Ventas',
                        data: [18000, 12000, 9000, 16000],
                        backgroundColor: gradient,
                        borderColor: '#ff7f50',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 6,
                        pointBackgroundColor: '#ff7f50',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: '#ff6347',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true,
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            padding: 12,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return 'Ventas: $' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            display: true,
                            grid: {
                                display: true,
                                color: 'rgba(0, 0, 0, 0.05)',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#6c757d',
                                font: {
                                    size: 12,
                                    weight: '500'
                                }
                            }
                        },
                        y: {
                            display: true,
                            grid: {
                                display: true,
                                color: 'rgba(0, 0, 0, 0.05)',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#6c757d',
                                font: {
                                    size: 12
                                },
                                callback: function(value) {
                                    return '$' + (value / 1000) + 'k';
                                }
                            },
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>
