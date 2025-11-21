<?php
require_once __DIR__ . '/../../php/database.php';

function manejarAccionesCarrito() {
    global $conexion;
  
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return false;
    }
    
    if (!isset($_SESSION['usuario_id'])) {
        echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
        exit;
    }
    
    $accion = $_POST['accion'] ?? '';
    $usuario_id = $_SESSION['usuario_id']; 
    
    if ($accion === 'actualizar_cantidad') {
        $producto_id = (int)$_POST['producto_id'];
        $cantidad = (int)$_POST['cantidad'];
        
        $sql = "UPDATE carrito SET cantidad = ? WHERE usuario_id = ? AND producto_id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("iii", $cantidad, $usuario_id, $producto_id);
        $stmt->execute();
        
        echo json_encode(['success' => true]);
        exit;
    }
    
    if ($accion === 'eliminar_producto') {
        $producto_id = (int)$_POST['producto_id'];
        
        $sql = "DELETE FROM carrito WHERE usuario_id = ? AND producto_id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ii", $usuario_id, $producto_id);
        $stmt->execute();
        
        echo json_encode(['success' => true]);
        exit;
    }
    
    return false;
}

function calcularTotales($conexion, $usuario_id) {
    $sql = "SELECT SUM(p.precio * c.cantidad) as subtotal 
            FROM carrito c 
            JOIN productos p ON c.producto_id = p.id 
            WHERE c.usuario_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $row = $resultado->fetch_assoc();
    
    $subtotal = $row['subtotal'] ?? 0;
    $envio = 150.00; 
    $iva = $subtotal * 0.16; 
    $total = $subtotal + $envio + $iva;
    
    return [
        'subtotal' => $subtotal,
        'envio' => $envio,
        'iva' => $iva,
        'total' => $total
    ];
}

function obtenerProductosCarrito($conexion, $usuario_id) {
    $sql = "SELECT p.id, p.nombre, p.precio, p.imagen, c.cantidad
            FROM carrito c
            JOIN productos p ON c.producto_id = p.id
            WHERE c.usuario_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    $productos = [];
    while ($row = $resultado->fetch_assoc()) {
        $productos[] = $row;
    }
    
    return $productos;
}

function generarHTMLProductosCarrito($productos) {
    if (empty($productos)) {
        return '<div class="alert alert-info">Tu carrito está vacío</div>';
    }
    $html = '<div class="row">';
    
    foreach ($productos as $producto) {
        $subtotal = $producto['precio'] * $producto['cantidad'];
        
        $html .= '
        <div class="col-md-6 mb-3" data-producto-id="' . $producto['id'] . '">
            <div class="card">
                <div class="row g-0">
                    <div class="col-4">
                        <img src="../img_productos/' . $producto['imagen'] . '" class="img-fluid" alt="' . $producto['nombre'] . '">
                    </div>
                    <div class="col-8">
                        <div class="card-body">
                            <h6>' . $producto['nombre'] . '</h6>
                            <p>Precio: $' . number_format($producto['precio'], 2) . '</p>
                            <p>Subtotal: $' . number_format($subtotal, 2) . '</p>
                            
                            <div class="d-flex align-items-center mb-2">
                                <button class="btn btn-sm btn-outline-secondary btn-restar">-</button>
                                <input type="number" class="form-control form-control-sm cantidad-input mx-2" style="width: 60px;" value="' . $producto['cantidad'] . '" min="1">
                                <button class="btn btn-sm btn-outline-secondary btn-sumar">+</button>
                            </div>
                            
                            <button class="btn btn-sm btn-danger btn-eliminar">Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    }
    
    $html .= '</div>';
    return $html;
}
function generarHTMLResumenPedido($totales) {
    return '
    <ul class="list-unstyled">
        <li class="d-flex justify-content-between">Subtotal: <span>$' . number_format($totales['subtotal'], 2) . '</span></li>
        <li class="d-flex justify-content-between">Envío: <span>$' . number_format($totales['envio'], 2) . '</span></li>
        <li class="d-flex justify-content-between">IVA (16%): <span>$' . number_format($totales['iva'], 2) . '</span></li>
    </ul>
    <hr>
    <p class="d-flex justify-content-between"><strong>Total: <span>$' . number_format($totales['total'], 2) . '</span></strong></p>
    <button class="btn btn-warning w-100">Proceder al Pago</button>';
}

function verificarSesionUsuario() {
    return true;
}
?>