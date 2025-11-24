<?php
require_once __DIR__ . '/../../php/database.php';

function obtenerDetallesPedido($pedido_id) {
    global $conexion;

    $sql = "SELECT 
                nombre_producto, cantidad, precio_unitario, total
            FROM detalles_pedido
            WHERE pedido_id = ?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $pedido_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $detalles = [];
    while ($row = $result->fetch_assoc()) {
        $detalles[] = $row;
    }
    $stmt->close();

    // Si no hay resultados
    if (empty($detalles)) {
        return '<p>No se encontraron detalles para este pedido.</p>';
    }

    // Generar tabla HTML
    $html = '<table class="table table-bordered">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>';

    foreach ($detalles as $detalle) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($detalle['nombre_producto']) . '</td>';
        $html .= '<td>' . $detalle['cantidad'] . '</td>';
        $html .= '<td>$' . number_format($detalle['precio_unitario'], 2) . '</td>';
        $html .= '<td>$' . number_format($detalle['total'], 2) . '</td>';
        $html .= '</tr>';
    }

    $html .= '</tbody></table>';
    return $html;
}
?>