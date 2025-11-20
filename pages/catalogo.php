<?php
require_once 'functions/f_catalogo.php';

$categoriaSeleccionada = isset($_GET['categoria']) ? $_GET['categoria'] : 'todas';

$productos = obtenerProductosCatalogo($categoriaSeleccionada);

$categorias = obtenerCategorias();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Repostería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light pt-4">
<?php include 'header.php'; ?>
    <div class="container">
        <!-- Header con colores de Bootstrap -->
        <div class="bg-primary text-white text-center py-4 mb-4 rounded">
            <h1 class="display-4">Catálogo de Repostería</h1>
            <p class="lead mb-0">Los mejores productos artesanales</p>
        </div>
        
        <!-- Filtros con card de Bootstrap -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <form method="get" class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <label for="categoria" class="form-label fw-bold">Filtrar por categoría:</label>
                    </div>
                    <div class="col-md-6">
                        <select name="categoria" id="categoria" class="form-select">
                            <option value="todas" <?= $categoriaSeleccionada == 'todas' ? 'selected' : '' ?>>Todas las categorías</option>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= htmlspecialchars($categoria) ?>" <?= $categoriaSeleccionada == $categoria ? 'selected' : '' ?>>
                                    <?= ucfirst(htmlspecialchars($categoria)) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Productos -->
        <div class="row">
            <?php if (empty($productos)): ?>
                <div class="col-12 text-center py-5">
                    <div class="alert alert-info">No se encontraron productos en esta categoría.</div>
                </div>
            <?php else: ?>
                <?php foreach ($productos as $producto): 
                    mostrarProducto($producto);
                endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/catalogo.js"></script>
</body>
</html>