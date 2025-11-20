<?php
require_once __DIR__ . '/../../php/database.php';
require_once 'f_login.php';

/**
 * Obtiene todos los datos del usuario incluyendo dirección principal
 */
function obtenerDatosCompletos($usuario_id) {
    global $conexion;
    
    $consulta = "SELECT u.*, d.alias, d.direccion, d.ciudad, d.codigo_postal, d.estado 
                 FROM usuarios u 
                 LEFT JOIN direcciones d ON u.id = d.usuario_id AND d.es_principal = 1 
                 WHERE u.id = ?";
    
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "i", $usuario_id);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    
    if ($usuario = mysqli_fetch_assoc($resultado)) {
        return $usuario;
    }
    return null;
}

/**
 * Obtiene el historial de pedidos del usuario
 */
function obtenerPedidosUsuario($usuario_id) {
    global $conexion;
    
    $consulta = "SELECT p.id, p.fecha_pedido, p.total, p.estado 
                 FROM pedidos p 
                 WHERE p.usuario_id = ? 
                 ORDER BY p.fecha_pedido DESC";
    
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "i", $usuario_id);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    
    $pedidos = [];
    while ($pedido = mysqli_fetch_assoc($resultado)) {
        $pedidos[] = $pedido;
    }
    return $pedidos;
}

/**
 * Obtiene todas las direcciones del usuario
 */
function obtenerDireccionesUsuario($usuario_id) {
    global $conexion;
    
    $consulta = "SELECT * FROM direcciones WHERE usuario_id = ? ORDER BY es_principal DESC, fecha_creacion DESC";
    
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "i", $usuario_id);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    
    $direcciones = [];
    while ($direccion = mysqli_fetch_assoc($resultado)) {
        $direcciones[] = $direccion;
    }
    return $direcciones;
}

function actualizarDatosPersonales($usuario_id, $datos) {
    global $conexion;
    
    $consulta = "UPDATE usuarios SET 
                 nombre = ?, 
                 apellido_paterno = ?, 
                 apellido_materno = ?, 
                 telefono = ? 
                 WHERE id = ?";
    
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "ssssi", 
        $datos['nombre'], 
        $datos['apellido_paterno'], 
        $datos['apellido_materno'], 
        $datos['telefono'], 
        $usuario_id
    );
    
    return mysqli_stmt_execute($stmt);
}

function manejarActualizacionDatos($usuario_id) {
    $resultado = ['exito' => false, 'mensaje' => '', 'datos' => null];
    
    if (isset($_POST['actualizar_datos'])) {
        $datos = [
            'nombre' => $_POST['nombre'],
            'apellido_paterno' => $_POST['apellido_paterno'],
            'apellido_materno' => $_POST['apellido_materno'],
            'telefono' => $_POST['telefono']
        ];
        
        if (actualizarDatosPersonales($usuario_id, $datos)) {
            $resultado['exito'] = true;
            $resultado['mensaje'] = "Datos actualizados correctamente";
            // Recargar datos
            $resultado['datos'] = obtenerDatosCompletos($usuario_id);
        } else {
            $resultado['mensaje'] = "Error al actualizar los datos";
        }
    }
    
    return $resultado;
}

function generarBadgeEstado($estado) {
    $badges = [
        'pendiente' => 'bg-warning text-dark',
        'procesando' => 'bg-info',
        'enviado' => 'bg-primary',
        'entregado' => 'bg-success',
        'cancelado' => 'bg-danger'
    ];
    
    $clase = $badges[$estado] ?? 'bg-secondary';
    return "<span class='badge {$clase}'>" . ucfirst($estado) . "</span>";
}

/**
 * Obtiene los productos favoritos del usuario
 */
function obtenerProductosFavoritos($usuario_id) {
    global $conexion;
    
    $consulta = "SELECT p.* FROM productos p 
                 INNER JOIN productos_favoritos pf ON p.id = pf.producto_id 
                 WHERE pf.usuario_id = ? 
                 ORDER BY pf.fecha_agregado DESC";
    
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "i", $usuario_id);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    
    $favoritos = [];
    while ($producto = mysqli_fetch_assoc($resultado)) {
        $favoritos[] = $producto;
    }
    return $favoritos;
}
?>