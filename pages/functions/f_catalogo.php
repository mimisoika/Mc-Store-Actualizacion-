<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__, 2) . '/php/database.php';

function obtenerProductosCatalogo($categoria = null) {
    global $conexion;
    
    $sql = "SELECT p.id, p.nombre, p.descripcion, p.precio, p.imagen, c.nombre as categoria 
            FROM productos p 
            LEFT JOIN categorias c ON p.categoria_id = c.id 
            WHERE p.estado = 'disponible'";
    
    if ($categoria && $categoria !== 'todas') {
        $sql .= " AND c.nombre = ?";
    }
    
    $sql .= " ORDER BY p.fecha_creacion DESC";
    
    $stmt = mysqli_prepare($conexion, $sql);
    
    if ($categoria && $categoria !== 'todas') {
        mysqli_stmt_bind_param($stmt, "s", $categoria);
    }
    
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    
    $productos = [];
    while ($producto = mysqli_fetch_assoc($resultado)) {
        $productos[] = $producto;
    }
    
    mysqli_stmt_close($stmt);
    return $productos;
}


function obtenerCategorias() {
    global $conexion;
    
    $sql = "SELECT DISTINCT c.nombre 
            FROM categorias c 
            INNER JOIN productos p ON c.id = p.categoria_id 
            WHERE p.estado = 'disponible' 
            ORDER BY c.nombre";
    $resultado = mysqli_query($conexion, $sql);
    
    $categorias = [];
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $categorias[] = $fila['nombre'];
    }
    
    return $categorias;
}

function agregarProductoAlCarrito($productoId, $cantidad = 1) {
    require_once 'f_index.php';
    return agregarAlCarrito($productoId, $cantidad);
}

/**
 * Obtener un producto por su ID
 */
function obtenerProductoPorId($id) {
    global $conexion;
    $sql = "SELECT p.id, p.nombre, p.descripcion, p.precio, p.cantidad, p.imagen, c.nombre as categoria
            FROM productos p
            LEFT JOIN categorias c ON p.categoria_id = c.id
            WHERE p.id = ? AND p.estado = 'disponible'";

    $stmt = mysqli_prepare($conexion, $sql);
    if (!$stmt) return null;
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $producto = mysqli_fetch_assoc($resultado);
    mysqli_stmt_close($stmt);
    return $producto;
}

function mostrarProducto($producto) {

    // Imagen segura
    $imagen = !empty($producto['imagen']) 
        ? '../img_productos/' . htmlspecialchars($producto['imagen']) 
        : '../img_productos/producto-default.jpg';

    // Favoritos
    $favoritos = isset($_SESSION['favoritos']) ? $_SESSION['favoritos'] : [];
    $isFav = in_array($producto['id'], $favoritos);

    echo '
    <div class="col-md-3 mb-3">
        <div class="card h-100 shadow-sm border-0 position-relative">

            <a href="producto.php?id=' . $producto['id'] . '" class="text-decoration-none text-dark">
                <img src="' . $imagen . '" 
                     class="card-img-top" 
                     style="height: 200px; object-fit: cover;" 
                     alt="' . htmlspecialchars($producto['nombre']) . '">
            </a>

            <div class="card-body">
                <a href="producto.php?id=' . $producto['id'] . '" class="text-decoration-none text-dark">
                    <h5 class="card-title">' . htmlspecialchars($producto['nombre']) . '</h5>
                </a>
                <p class="card-text text-muted">' . htmlspecialchars($producto['descripcion']) . '</p>
            </div>

            <div class="card-footer bg-white border-0">
                <div class="d-flex align-items-center gap-2">

                    <div class="text-primary fw-bold fs-5 mb-0 me-2">
                        $' . number_format($producto['precio'], 2) . '
                    </div>

                    <button class="btn btn-outline-primary"
                        onclick="agregarAlCarrito(' . $producto['id'] . ')">
                        <i class="bi bi-cart-plus"></i>
                    </button>

                    <button class="btn ' . ($isFav ? 'btn-danger' : 'btn-outline-danger') . ' btn-sm"
                        onclick="toggleFavorito(' . $producto['id'] . ', this)" 
                        title="Añadir a favoritos">
                        <i class="' . ($isFav ? 'fas' : 'far') . ' fa-heart"></i>
                    </button>

                </div>
            </div>

        </div>
    </div>
    ';
}

?>