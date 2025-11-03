<?php
require_once '../../../php/database.php';

// Verificar conexión
if (!$conexion) {
    echo json_encode(['success' => false, 'mensaje' => 'Error de conexión']);
    exit();
}

// Función para obtener todos los productos
function obtenerProductos() {
    global $conexion;
    $sql = "SELECT p.*, c.nombre as categoria FROM productos p LEFT JOIN categorias c ON p.categoria_id = c.id ORDER BY p.id DESC";
    $resultado = mysqli_query($conexion, $sql);
    $productos = [];
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $productos[] = $fila;
    }
    return $productos;
}

// Función para obtener categorías
function obtenerCategorias() {
    global $conexion;
    $sql = "SELECT * FROM categorias ORDER BY nombre";
    $resultado = mysqli_query($conexion, $sql);
    $categorias = [];
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $categorias[] = $fila;
    }
    return $categorias;
}

// Función para agregar producto
function agregarProducto($nombre, $precio, $categoria, $descripcion, $cantidad, $imagen = '') {
    global $conexion;
    
    // Obtener ID de categoría
    $sql_cat = "SELECT id FROM categorias WHERE nombre = '$categoria'";
    $resultado_cat = mysqli_query($conexion, $sql_cat);
    $categoria_data = mysqli_fetch_assoc($resultado_cat);
    $categoria_id = $categoria_data['id'];
    
    // Insertar producto
    $sql = "INSERT INTO productos (categoria_id, nombre, descripcion, precio, cantidad, estado, imagen) 
            VALUES ('$categoria_id', '$nombre', '$descripcion', '$precio', '$cantidad', 'disponible', '$imagen')";
    
    return mysqli_query($conexion, $sql);
}

// Función para actualizar producto
function actualizarProducto($id, $nombre, $precio, $categoria, $descripcion, $cantidad, $imagen = null) {
    global $conexion;
    
    // Obtener ID de categoría
    $sql_cat = "SELECT id FROM categorias WHERE nombre = '$categoria'";
    $resultado_cat = mysqli_query($conexion, $sql_cat);
    $categoria_data = mysqli_fetch_assoc($resultado_cat);
    $categoria_id = $categoria_data['id'];
    
    if ($imagen) {
        $sql = "UPDATE productos SET categoria_id='$categoria_id', nombre='$nombre', descripcion='$descripcion', 
                precio='$precio', cantidad='$cantidad', imagen='$imagen' WHERE id='$id'";
    } else {
        $sql = "UPDATE productos SET categoria_id='$categoria_id', nombre='$nombre', descripcion='$descripcion', 
                precio='$precio', cantidad='$cantidad' WHERE id='$id'";
    }
    
    return mysqli_query($conexion, $sql);
}

// Función para eliminar (suspender) producto
function eliminarProducto($id) {
    global $conexion;
    $sql = "UPDATE productos SET estado = 'suspendido' WHERE id = '$id'";
    return mysqli_query($conexion, $sql);
}

// Función para obtener un producto específico
function obtenerProducto($id) {
    global $conexion;
    $sql = "SELECT p.*, c.nombre as categoria FROM productos p LEFT JOIN categorias c ON p.categoria_id = c.id WHERE p.id = '$id'";
    $resultado = mysqli_query($conexion, $sql);
    return mysqli_fetch_assoc($resultado);
}

// Función para subir imagen
function subirImagen($archivo) {
    $carpeta = '../../../img_productos/';
    $nombre = time() . '_' . $archivo['name'];
    $ruta = $carpeta . $nombre;
    
    if (move_uploaded_file($archivo['tmp_name'], $ruta)) {
        return $nombre;
    }
    return false;
}

// Procesar peticiones AJAX
if ($_POST) {
    $accion = $_POST['accion'];
    
    if ($accion == 'obtener_productos') {
        $productos = obtenerProductos();
        echo json_encode(['success' => true, 'productos' => $productos]);
    }
    
    elseif ($accion == 'obtener_categorias') {
        $categorias = obtenerCategorias();
        echo json_encode(['success' => true, 'categorias' => $categorias]);
    }
    
    elseif ($accion == 'agregar_producto') {
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $categoria = $_POST['categoria'];
        $descripcion = $_POST['descripcion'];
        $cantidad = $_POST['cantidad'];
        
        $imagen = '';
        if ($_FILES['imagen']['name']) {
            $imagen = subirImagen($_FILES['imagen']);
        }
        
        $resultado = agregarProducto($nombre, $precio, $categoria, $descripcion, $cantidad, $imagen);
        
        if ($resultado) {
            echo json_encode(['success' => true, 'mensaje' => 'Producto agregado correctamente']);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Error al agregar producto']);
        }
    }
    
    elseif ($accion == 'actualizar_producto') {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $categoria = $_POST['categoria'];
        $descripcion = $_POST['descripcion'];
        $cantidad = $_POST['cantidad'];
        
        $imagen = null;
        if ($_FILES['imagen']['name']) {
            $imagen = subirImagen($_FILES['imagen']);
        }
        
        $resultado = actualizarProducto($id, $nombre, $precio, $categoria, $descripcion, $cantidad, $imagen);
        
        if ($resultado) {
            echo json_encode(['success' => true, 'mensaje' => 'Producto actualizado correctamente']);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Error al actualizar producto']);
        }
    }
    
    elseif ($accion == 'eliminar_producto') {
        $id = $_POST['id'];
        $resultado = eliminarProducto($id);
        
        if ($resultado) {
            echo json_encode(['success' => true, 'mensaje' => 'Producto eliminado correctamente']);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Error al eliminar producto']);
        }
    }
    
    elseif ($accion == 'obtener_producto') {
        $id = $_POST['id'];
        $producto = obtenerProducto($id);
        
        if ($producto) {
            echo json_encode(['success' => true, 'producto' => $producto]);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Producto no encontrado']);
        }
    }
}
?>