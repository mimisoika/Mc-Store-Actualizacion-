<?php
require_once 'functions/f_catalogo.php';
require_once 'functions/f_favoritos.php';

$categoriaSeleccionada = isset($_GET['categoria']) ? $_GET['categoria'] : 'todas';
$minPrecio = isset($_GET['min_precio']) ? $_GET['min_precio'] : '';
$maxPrecio = isset($_GET['max_precio']) ? $_GET['max_precio'] : '';
$orden = isset($_GET['orden']) ? $_GET['orden'] : '';

$categorias = obtenerCategorias();
$rangoPrecios = obtenerRangoPrecios();

// Defaults if not provided
if ($minPrecio === '') $minPrecio = $rangoPrecios['min'];
if ($maxPrecio === '') $maxPrecio = $rangoPrecios['max'];

$productos = obtenerProductosCatalogo($categoriaSeleccionada, $minPrecio, $maxPrecio, $orden);
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
        
        <!-- Filtros laterales y Productos -->
        <div class="row">
            <div class="col-lg-3 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <strong>Filtros</strong>
                    </div>
                    <div class="card-body">
                        <form id="filterForm" method="get">
                            <div class="mb-3">
                                <label for="categoria" class="form-label fw-bold">Categoría</label>
                                <select name="categoria" id="categoria" class="form-select">
                                    <option value="todas" <?= $categoriaSeleccionada == 'todas' ? 'selected' : '' ?>>Todas las categorías</option>
                                    <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?= htmlspecialchars($categoria) ?>" <?= $categoriaSeleccionada == $categoria ? 'selected' : '' ?>>
                                            <?= ucfirst(htmlspecialchars($categoria)) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Rango de Precio</label>
                                
                                <!-- Sliders -->
                                <div class="mb-3">
                                    <label class="form-label small">Precio Mínimo: $<span id="minPrecioVal"><?= number_format($minPrecio, 2) ?></span></label>
                                    <input type="range" id="minPrecioRange" name="min_precio" min="1" max="<?= $rangoPrecios['max'] ?>" value="<?= htmlspecialchars($minPrecio) ?>" class="form-range" style="height: 6px; width: 100%;">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label small">Precio Máximo: $<span id="maxPrecioVal"><?= number_format($maxPrecio, 2) ?></span></label>
                                    <input type="range" id="maxPrecioRange" name="max_precio" min="1" max="<?= $rangoPrecios['max'] ?>" value="<?= htmlspecialchars($maxPrecio) ?>" class="form-range" style="height: 6px; width: 100%;">
                                </div>

                                <!-- Numeric inputs removed per request -->
                            </div>

                            <div class="mb-3">
                                <label for="orden" class="form-label fw-bold">Ordenar por</label>
                                <select name="orden" id="orden" class="form-select">
                                    <option value="mas_reciente" <?= $orden == 'mas_reciente' ? 'selected' : '' ?>>Más reciente</option>
                                    <option value="menos_reciente" <?= $orden == 'menos_reciente' ? 'selected' : '' ?>>Menos reciente</option>
                                    <option value="precio_asc" <?= $orden == 'precio_asc' ? 'selected' : '' ?>>Precio: menor a mayor</option>
                                    <option value="precio_desc" <?= $orden == 'precio_desc' ? 'selected' : '' ?>>Precio: mayor a menor</option>
                                    <option value="nombre_asc" <?= $orden == 'nombre_asc' ? 'selected' : '' ?>>Nombre A-Z</option>
                                    <option value="nombre_desc" <?= $orden == 'nombre_desc' ? 'selected' : '' ?>>Nombre Z-A</option>
                                </select>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Aplicar filtros</button>
                                <a href="catalogo.php" class="btn btn-outline-secondary">Limpiar filtros</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <!-- Productos -->
                <div class="row">
            <?php if (empty($productos)): ?>
                <div class="col-12 text-center py-5">
                    <div class="alert alert-info">No se encontraron productos en esta categoría.</div>
                </div>
            <?php else: ?>
                <?php foreach ($productos as $producto): 
                    mostrarProducto($producto, $favoritosIds);
                endforeach; ?>
            <?php endif; ?>
                </div> <!-- /.inner row -->
            </div> <!-- /.col-lg-9 -->
        </div> <!-- /.outer row -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/catalogo.js"></script>
    <script src="js/favoritos.js"></script>
</body>
</html>