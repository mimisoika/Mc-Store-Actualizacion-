<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__, 2) . '/php/database.php';

function obtenerProductosDestacados($limite = 4) {
    global $conexion;
    
    $sql = "SELECT id, nombre, descripcion, precio, imagen 
            FROM productos 
            WHERE estado = 'disponible' AND destacado = 'si'
            ORDER BY fecha_creacion DESC 
            LIMIT ?";
    
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $limite);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    
    $productos = [];
    while ($producto = mysqli_fetch_assoc($resultado)) {
        $productos[] = $producto;
    }
    
    mysqli_stmt_close($stmt);
    return $productos;
}

function agregarAlCarrito($productoId, $cantidad = 1) {
    global $conexion;
    
    if (!isset($_SESSION['usuario_id'])) {
        return array('success' => false, 'message' => 'Debe iniciar sesión');
    }
    
    $usuarioId = $_SESSION['usuario_id'];
    
    $sql = "SELECT cantidad FROM carrito WHERE producto_id = ? AND usuario_id = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $productoId, $usuarioId);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);
        $nuevaCantidad = $fila['cantidad'] + $cantidad;
        $sql = "UPDATE carrito SET cantidad = ? WHERE producto_id = ? AND usuario_id = ?";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "iii", $nuevaCantidad, $productoId, $usuarioId);
        $exito = mysqli_stmt_execute($stmt);
        $mensaje = $exito ? 'Cantidad actualizada' : 'Error al actualizar';
    } else {
        $sql = "INSERT INTO carrito (producto_id, usuario_id, cantidad) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "iii", $productoId, $usuarioId, $cantidad);
        $exito = mysqli_stmt_execute($stmt);
        $mensaje = $exito ? 'Producto agregado al carrito' : 'Error al agregar producto';
    }
    
    mysqli_stmt_close($stmt);
    return array('success' => $exito, 'message' => $mensaje);
}

function mostrarProductosDestacados() {
    $productos = obtenerProductosDestacados(4);
    
    if (empty($productos)) {
        echo '<div class="col-12 text-center">';
        echo '<p class="text-muted">No hay productos destacados disponibles en este momento.</p>';
        echo '</div>';
        return;
    }
    
    foreach ($productos as $producto) {
        echo '<div class="col-lg-3 col-md-6">';
        echo '    <div class="card h-100 shadow-sm">';
        
        $imagen = !empty($producto['imagen']) ? $producto['imagen'] : 'img_productos/producto-default.jpg';
        echo '        <img src="' . htmlspecialchars($imagen) . '" class="card-img-top" alt="' . htmlspecialchars($producto['nombre']) . '" style="height: 200px; object-fit: cover;">';
        
        echo '        <div class="card-body d-flex flex-column">';
        echo '            <h5 class="card-title">' . htmlspecialchars($producto['nombre']) . '</h5>';
        echo '            <p class="card-text flex-grow-1">' . htmlspecialchars($producto['descripcion']) . '</p>';
        echo '            <div class="d-flex justify-content-between align-items-center">';
        echo '                <span class="h5 text-primary mb-0">$' . number_format($producto['precio'], 2) . '</span>';
        echo '                <button class="btn btn-primary" onclick="agregarAlCarrito(' . $producto['id'] . ')">Agregar</button>';
        echo '            </div>';
        echo '        </div>';
        echo '    </div>';
        echo '</div>';
    }
}
?>