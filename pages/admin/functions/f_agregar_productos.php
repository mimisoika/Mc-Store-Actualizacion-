<?php
// Asegúrate de que esta ruta sea correcta para tu conexión MySQLi
require_once '../../../php/database.php'; 

// Encabezado para la respuesta JSON
header('Content-Type: application/json');

// Verificar conexión (asumiendo que $conexion viene de database.php)
if (!$conexion) {
    echo json_encode(['success' => false, 'mensaje' => 'Error de conexión']);
    exit();
}

// --- FUNCIONES CRUD ---

// Función para obtener todos los productos
function obtenerProductos() {
    global $conexion;
    // La consulta original es correcta para traer todos los datos
    $sql = "SELECT p.*, c.nombre as categoria 
            FROM productos p 
            LEFT JOIN categorias c ON p.categoria_id = c.id 
            ORDER BY p.id DESC";
    
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
    $sql = "SELECT id, nombre FROM categorias ORDER BY nombre"; // Incluyo el ID para el frontend
    $resultado = mysqli_query($conexion, $sql);
    $categorias = [];
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $categorias[] = $fila;
    }
    return $categorias;
}

// En la función agregarProducto(), agrega el parámetro $destacado:
function agregarProducto($nombre, $precio, $categoria, $descripcion, $cantidad, $estado, $destacado, $imagen = '') {
    global $conexion;
    
    // ** CORRECCIÓN: Sanitizar y asegurar que la cantidad sea un entero **
    $cantidad_entero = intval($cantidad); 
    
    // Normalizar y validar estado contra los valores permitidos
    $estado = strtolower(trim($estado));
    $allowedEstados = ['disponible', 'suspendido', 'agotado'];
    if (!in_array($estado, $allowedEstados, true)) {
        $estado = 'disponible';
    }

    // Escapar cadenas para evitar errores y mitigar (ligeramente) inyección SQL
    $nombre = mysqli_real_escape_string($conexion, $nombre);
    $descripcion = mysqli_real_escape_string($conexion, $descripcion);
    $precio = mysqli_real_escape_string($conexion, $precio);
    $estado = mysqli_real_escape_string($conexion, $estado);
    $imagen = mysqli_real_escape_string($conexion, $imagen);
    
    // Buscar el ID de la categoría usando el nombre
    $sql_cat = "SELECT id FROM categorias WHERE nombre = '" . mysqli_real_escape_string($conexion, $categoria) . "'";
    $resultado_cat = mysqli_query($conexion, $sql_cat);
    $categoria_data = mysqli_fetch_assoc($resultado_cat);
    
    if (!$categoria_data) {
        // Manejar el caso donde la categoría no existe
        return false; 
    }
    $categoria_id = $categoria_data['id'];
    
    // Insertar producto, usando $cantidad_entero
    $sql = "INSERT INTO productos (categoria_id, nombre, descripcion, precio, cantidad, estado, imagen, destacado) 
             VALUES ('$categoria_id', '$nombre', '$descripcion', '$precio', '$cantidad_entero', '$estado', '$imagen', '$destacado')";
    
    return mysqli_query($conexion, $sql);
}

// En la función actualizarProducto(), agrega el parámetro $destacado:
function actualizarProducto($id, $nombre, $precio, $categoria, $descripcion, $cantidad, $estado, $destacado, $imagen = null) {
    global $conexion;
    
    // ** CORRECCIÓN: Sanitizar y asegurar que la cantidad sea un entero **
    $cantidad_entero = intval($cantidad); 
    
    // Normalizar y validar estado contra los valores permitidos
    $estado = strtolower(trim($estado));
    $allowedEstados = ['disponible', 'suspendido', 'agotado'];
    if (!in_array($estado, $allowedEstados, true)) {
        $estado = 'disponible';
    }

    // Escapar cadenas
    $id = mysqli_real_escape_string($conexion, $id);
    $nombre = mysqli_real_escape_string($conexion, $nombre);
    $descripcion = mysqli_real_escape_string($conexion, $descripcion);
    $precio = mysqli_real_escape_string($conexion, $precio);
    $estado = mysqli_real_escape_string($conexion, $estado);
    
    // Buscar el ID de la categoría usando el nombre
    $sql_cat = "SELECT id FROM categorias WHERE nombre = '" . mysqli_real_escape_string($conexion, $categoria) . "'";
    $resultado_cat = mysqli_query($conexion, $sql_cat);
    $categoria_data = mysqli_fetch_assoc($resultado_cat);
    
    if (!$categoria_data) {
        return false;
    }
    $categoria_id = $categoria_data['id'];
    
    // Construir la consulta de actualización, usando $cantidad_entero y
    $set_parts = [
        "categoria_id='$categoria_id'",
        "nombre='$nombre'",
        "descripcion='$descripcion'",
        "precio='$precio'",
        "cantidad='$cantidad_entero'", // <-- Usando la variable entera
        "estado='$estado'",
        "destacado='$destacado'"
    ];
    
    if ($imagen !== null) {
        $imagen_escapada = mysqli_real_escape_string($conexion, $imagen);
        $set_parts[] = "imagen='$imagen_escapada'";
    }
    
    $sql = "UPDATE productos SET " . implode(', ', $set_parts) . " WHERE id='$id'";
    
    return mysqli_query($conexion, $sql);
}
// Función para eliminar (suspender) producto
function eliminarProducto($id) {
    global $conexion;
    $id = mysqli_real_escape_string($conexion, $id);
    $sql = "UPDATE productos SET estado = 'suspendido' WHERE id = '$id'";
    return mysqli_query($conexion, $sql);
}

// Función para obtener un producto específico
function obtenerProducto($id) {
    global $conexion;
    $id = mysqli_real_escape_string($conexion, $id);
    $sql = "SELECT p.*, c.nombre as categoria FROM productos p 
            LEFT JOIN categorias c ON p.categoria_id = c.id 
            WHERE p.id = '$id'";
    $resultado = mysqli_query($conexion, $sql);
    return mysqli_fetch_assoc($resultado);
}

// Función para subir imagen
function subirImagen($archivo) {
    // La ruta relativa debe ser correcta desde donde se ejecuta el script
    $carpeta = '../../../img_productos/';
    $nombre = time() . '_' . basename($archivo['name']);
    $ruta = $carpeta . $nombre;
    
    // Crear la carpeta si no existe (importante)
    if (!is_dir($carpeta)) {
        mkdir($carpeta, 0777, true);
    }
    
    if (move_uploaded_file($archivo['tmp_name'], $ruta)) {
        return $nombre;
    }
    return false;
}

// --- Procesar peticiones AJAX ---

if ($_POST) {
    $accion = $_POST['accion'] ?? '';
    
    if ($accion == 'obtener_productos') {
        $filtroCategoria = isset($_POST['filtroCategoria']) ? trim($_POST['filtroCategoria']) : '';
        $filtroEstado = isset($_POST['filtroEstado']) ? trim($_POST['filtroEstado']) : '';
        $busqueda = isset($_POST['busqueda']) ? trim($_POST['busqueda']) : '';

        // Mapeo de estados del frontend (activo/inactivo) a la DB (disponible/suspendido)
        $estadoMap = [
            'activo' => 'disponible',
            'inactivo' => 'suspendido',
            'disponible' => 'disponible',
            'suspendido' => 'suspendido',
            'agotado' => 'agotado'
        ];

        if ($filtroEstado !== '' && $filtroEstado !== 'todos') {
            $filtroEstado = $estadoMap[$filtroEstado] ?? $filtroEstado;
        } else {
            $filtroEstado = '';
        }

        $productos = obtenerProductos();

        // Aplicar filtros en PHP (como ya lo tienes)
        if ($filtroCategoria !== '' && $filtroCategoria !== 'todas') {
            $productos = array_filter($productos, function($p) use ($filtroCategoria) {
                return isset($p['categoria']) && mb_strtolower($p['categoria']) === mb_strtolower($filtroCategoria);
            });
        }
        if ($filtroEstado !== '') {
            $productos = array_filter($productos, function($p) use ($filtroEstado) {
                return isset($p['estado']) && $p['estado'] === $filtroEstado;
            });
        }
        if ($busqueda !== '') {
            $q = mb_strtolower($busqueda);
            $productos = array_filter($productos, function($p) use ($q) {
                $nombre = isset($p['nombre']) ? mb_strtolower($p['nombre']) : '';
                $descripcion = isset($p['descripcion']) ? mb_strtolower($p['descripcion']) : '';
                return mb_strpos($nombre, $q) !== false || mb_strpos($descripcion, $q) !== false;
            });
        }

        $productos = array_values($productos);
        echo json_encode(['success' => true, 'productos' => $productos]);

    } elseif ($accion == 'obtener_categorias') {
        $categorias = obtenerCategorias();
        echo json_encode(['success' => true, 'categorias' => $categorias]);

    } elseif ($accion == 'agregar_producto') {
        $nombre = $_POST['nombre'] ?? '';
        $precio = $_POST['precio'] ?? 0;
        $categoria = $_POST['categoria'] ?? ''; // Nombre de la categoría
        $descripcion = $_POST['descripcion'] ?? '';
        $cantidad = $_POST['stock'] ?? 0; // El JS envía 'stock'
        $estado = $_POST['estado'] ?? 'disponible';
        $destacado = $_POST['destacado'] ?? 'no'; // <-- FALTA ESTA LÍNEA
        
        // Mapear valores comunes del frontend a los valores ENUM de la BD
        $estadoMap = [
            'activo' => 'disponible',
            'inactivo' => 'suspendido',
            'disponible' => 'disponible',
            'suspendido' => 'suspendido',
            'agotado' => 'agotado'
        ];
        $estado = $estadoMap[strtolower($estado)] ?? $estado;
        
        $imagen = '';
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $imagen = subirImagen($_FILES['imagen']);
        }
        
        // Agrega $destacado a la llamada de la función
        $resultado = agregarProducto($nombre, $precio, $categoria, $descripcion, $cantidad, $estado, $destacado, $imagen);
        
        if ($resultado) {
            echo json_encode(['success' => true, 'mensaje' => 'Producto agregado correctamente']);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Error al agregar producto: ' . mysqli_error($conexion)]);
        }

    } elseif ($accion == 'actualizar_producto') {
        $id = $_POST['id'] ?? 0;
        $nombre = $_POST['nombre'] ?? '';
        $precio = $_POST['precio'] ?? 0;
        $categoria = $_POST['categoria'] ?? ''; // Nombre de la categoría
        $descripcion = $_POST['descripcion'] ?? '';
        $cantidad = $_POST['stock'] ?? 0; // El JS envía 'stock'
        $estado = $_POST['estado'] ?? 'disponible';
        $destacado = $_POST['destacado'] ?? 'no'; // <-- FALTA ESTA LÍNEA
        
        // Mapear valores comunes del frontend a los valores ENUM de la BD
        $estadoMap = [
            'activo' => 'disponible',
            'inactivo' => 'suspendido',
            'disponible' => 'disponible',
            'suspendido' => 'suspendido',
            'agotado' => 'agotado'
        ];
        $estado = $estadoMap[strtolower($estado)] ?? $estado;
        
        $imagen = null;
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $imagen = subirImagen($_FILES['imagen']);
        }
        
        // Agrega $destacado a la llamada de la función
        $resultado = actualizarProducto($id, $nombre, $precio, $categoria, $descripcion, $cantidad, $estado, $destacado, $imagen);
        
        if ($resultado) {
            echo json_encode(['success' => true, 'mensaje' => 'Producto actualizado correctamente']);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Error al actualizar producto: ' . mysqli_error($conexion)]);
        }

            
    } elseif ($accion == 'eliminar_producto') {
        $id = $_POST['id'] ?? 0;
        $resultado = eliminarProducto($id);
        
        if ($resultado) {
            echo json_encode(['success' => true, 'mensaje' => 'Producto suspendido correctamente']);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Error al suspender producto']);
        }

    } elseif ($accion == 'obtener_producto') {
        $id = $_POST['id'] ?? 0;
        $producto = obtenerProducto($id);
        
        if ($producto) {
            echo json_encode(['success' => true, 'producto' => $producto]);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Producto no encontrado']);
        }
    }
} else {
    echo json_encode(['success' => false, 'mensaje' => 'Petición inválida']);
}
?>