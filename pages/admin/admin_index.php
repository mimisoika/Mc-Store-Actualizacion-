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
                <a href="#" class="menu-item active" data-section="dashboard">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
                <a href="gestions_de_productos.php" class="menu-item">
                    <i class="bi bi-box-seam"></i>
                    <span>Productos</span>
                </a>
                <a href="#" class="menu-item" data-section="pedidos">
                    <i class="bi bi-clipboard-check"></i>
                    <span>Pedidos</span>
                </a>
                <a href="gestion_de_usuarios.php" class="menu-item">
                    <i class="bi bi-people-fill"></i>
                    <span>Usuarios</span>
                </a>
                <a href="#" class="menu-item" data-section="categorias">
                    <i class="bi bi-tag"></i>
                    <span>Categorias</span>
                </a>
                <a href="#" class="menu-item" data-section="configuracion">
                    <i class="bi bi-gear"></i>
                    <span>Configuracion</span>
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <a href="../../index.php" class="menu-item">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Cerrar Sesion</span>
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
                <div class="content-header">
                    <h2>Dashboard</h2>
                </div>
                
                <!-- Sección de Gráficos -->
                <div class="dashboard-section">
                    <h3>Resumen de Pedidos</h3>
                    <div class="chart-container">
                        <div class="chart-wrapper">
                            <canvas id="pedidosChart"></canvas>
                        </div>
                    </div>
                </div>
                
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="js/admin_index.js"></script>
</body>
</html>