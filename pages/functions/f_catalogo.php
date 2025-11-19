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
 * Obtener productos aleatorios por categoría
 * @param string|null $categoria Nombre de la categoría (o null/'todas' para cualquier categoría)
 * @param int $limite Cantidad de productos a retornar
 * @return array
 */
function obtenerProductosAleatoriosPorCategoria($categoria = null, $limite = 4) {
    global $conexion;

    $sql = "SELECT p.id, p.nombre, p.descripcion, p.precio, p.cantidad, p.imagen, c.nombre as categoria
        FROM productos p
        LEFT JOIN categorias c ON p.categoria_id = c.id
        WHERE p.estado = 'disponible' AND p.cantidad > 0";

    if ($categoria && $categoria !== 'todas') {
        $sql .= " AND c.nombre = ?";
    }

    $sql .= " ORDER BY RAND() LIMIT ?";

    $stmt = mysqli_prepare($conexion, $sql);
    if (!$stmt) {
        error_log("[f_catalogo] mysqli_prepare failed: " . mysqli_error($conexion) . " -- SQL: " . $sql);
        return [];
    }

    if ($categoria && $categoria !== 'todas') {
        // Bind category (string) and limit (int)
        mysqli_stmt_bind_param($stmt, "si", $categoria, $limite);
    } else {
        // Only limit
        mysqli_stmt_bind_param($stmt, "i", $limite);
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
?>