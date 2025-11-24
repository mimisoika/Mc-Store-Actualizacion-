<?php
require_once __DIR__ . '/../../php/database.php';

function enviarPedido($usuario_id, $direccion_id, $total, $metodo_pago){
    if (session_status() === PHP_SESSION_NONE) {
    session_start();
    }
    global $conexion;

    // Primero se hacer el envio de los datos a la tabla pedidos
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Son los datos que se estan recibiendo en el form
        $usuario_id = $_SESSION['usuario_id'];
        $direccion_id = trim($_POST['direccion_id']);
        $total = trim($_POST['total']);
        $metodo_pago = trim($_POST['metodo_pago']);
    }

    $sql = "INSERT INTO pedidos (
            usuario_id, direccion_id, total, metodo_pago
        ) VALUES (?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('iids', $usuario_id, $direccion_id, $total, $metodo_pago);
    if (!$stmt->execute()) {
        die("Error al crear el pedido: " . $stmt->error);
    }

    $pedido_id = $stmt->insert_id; // ID del nuevo pedido
    $stmt->close();

    //Luego se obtienen productos del carrito del usuario
    $sql = "SELECT c.producto_id, p.nombre, p.precio, c.cantidad
            FROM carrito c
            JOIN productos p ON c.producto_id = p.id
            WHERE c.usuario_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('i', $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();


    $sql_insert_detalle = "INSERT INTO detalles_pedido (pedido_id, producto_id, nombre_producto, cantidad, precio_unitario, total)
                           VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_detalle = $conexion->prepare($sql_insert_detalle);

    while ($row = $result->fetch_assoc()) {
        $producto_id = $row['producto_id'];
        $nombre_producto = $row['nombre'];
        $cantidad = $row['cantidad'];
        $precio_unitario = $row['precio'];
        $total_detalle = $precio_unitario * $cantidad;

        // Insertar detalle del pedido
        $stmt_detalle->bind_param('iisidd', $pedido_id, $producto_id, $nombre_producto, $cantidad, $precio_unitario, $total_detalle);
        if (!$stmt_detalle->execute()) {
            die("Error al guardar detalle del pedido: " . $stmt_detalle->error);
        }

        // Descontar del campo 'cantidad' (que es tu stock real en productos)
        $sql_update_stock = "UPDATE productos SET cantidad = cantidad - ? WHERE id = ? AND cantidad >= ?";
        $stmt_update = $conexion->prepare($sql_update_stock);
        $stmt_update->bind_param('iii', $cantidad, $producto_id, $cantidad);
        if (!$stmt_update->execute()) {
            die("Error al actualizar el stock: " . $stmt_update->error);
        }
        $stmt_update->close();
    }

    //Vaciar el carrito del usuario
    $sql = "DELETE FROM carrito WHERE usuario_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('i', $usuario_id);
    $stmt->execute();
    $stmt->close();

    //Redirigir a página de confirmación
    header("Location: perfil.php");
    exit();

}        
        
?>