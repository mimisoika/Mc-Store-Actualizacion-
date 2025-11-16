<?php
// Configuración de la base de datos
$host = "mcstore-g9546534-66a9.e.aivencloud.com";
$usuario = "ComercializadoraMC";
$contrasena = "AVNS_9HsvpMzjKrUnv8b6Mao";
$baseDeDatos = "comercializadora";
$puerto = 20673; 

// Configuración de timeouts
ini_set('default_socket_timeout', 2); // 10 segundos timeout
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Función mejorada para probar la conexión
function probarConexionMejorada() {
    global $host, $usuario, $contrasena, $baseDeDatos, $puerto;
    
    echo "<div style='font-family: Arial, sans-serif; max-width: 900px; margin: 20px auto; padding: 20px; background: #f8f9fa; border-radius: 10px;'>";
    echo "<h2 style='color: #333; text-align: center; margin-bottom: 30px;'>🔍 Diagnóstico Avanzado de Conexión</h2>";
    
    // Información de conexión
    echo "<div style='background: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #007bff;'>";
    echo "<h3 style='color: #007bff; margin-top: 0;'>📋 Configuración de Conexión</h3>";
    echo "<p><strong>Servidor:</strong> " . htmlspecialchars($host) . "</p>";
    echo "<p><strong>Puerto:</strong> " . htmlspecialchars($puerto) . "</p>";
    echo "<p><strong>Usuario:</strong> " . htmlspecialchars($usuario) . "</p>";
    echo "<p><strong>Base de Datos:</strong> " . htmlspecialchars($baseDeDatos) . "</p>";
    echo "<p><strong>Timeout:</strong> 10 segundos</p>";
    echo "</div>";
    
    // Prueba de conectividad básica
    echo "<div style='background: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;'>";
    echo "<h3 style='color: #333; margin-top: 0;'>🌐 Prueba de Conectividad</h3>";
    
    // Verificar si el host es alcanzable
    $hostReachable = checkHostReachability($host, $puerto);
    if ($hostReachable) {
        echo "<div style='background: #d4edda; color: #155724; padding: 12px; border-radius: 6px; border: 1px solid #c3e6cb; margin-bottom: 10px;'>";
        echo "<strong>✅ Host alcanzable:</strong> El servidor responde en el puerto " . $puerto;
        echo "</div>";
    } else {
        echo "<div style='background: #f8d7da; color: #721c24; padding: 12px; border-radius: 6px; border: 1px solid #f5c6cb; margin-bottom: 10px;'>";
        echo "<strong>❌ Host no alcanzable:</strong> No se puede conectar al servidor en el puerto " . $puerto;
        echo "<br><small>Esto puede indicar problemas de red, firewall o que el servidor esté inactivo.</small>";
        echo "</div>";
    }
    echo "</div>";
    
    // Intentar conexión con manejo de excepciones
    echo "<div style='background: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;'>";
    echo "<h3 style='color: #333; margin-top: 0;'>🔌 Prueba de Conexión MySQL</h3>";
    
    $conexion = null;
    $tiempoInicio = microtime(true);
    
    try {
        // Intentar conexión con timeout personalizado
        $conexion = @mysqli_connect($host, $usuario, $contrasena, $baseDeDatos, $puerto);
        
        if (!$conexion) {
            throw new Exception(mysqli_connect_error());
        }
        
        $tiempoConexion = round((microtime(true) - $tiempoInicio) * 1000, 2);
        
        echo "<div style='background: #d4edda; color: #155724; padding: 12px; border-radius: 6px; border: 1px solid #c3e6cb;'>";
        echo "<strong>✅ ¡Conexión exitosa!</strong><br>";
        echo "<small>Tiempo de conexión: " . $tiempoConexion . " ms</small>";
        echo "</div>";
        
    } catch (Exception $e) {
        $tiempoConexion = round((microtime(true) - $tiempoInicio) * 1000, 2);
        
        echo "<div style='background: #f8d7da; color: #721c24; padding: 12px; border-radius: 6px; border: 1px solid #f5c6cb;'>";
        echo "<strong>❌ Error de Conexión:</strong><br>";
        echo htmlspecialchars($e->getMessage()) . "<br>";
        echo "<small>Tiempo transcurrido: " . $tiempoConexion . " ms</small><br><br>";
        
        // Diagnóstico del error
        $errorMsg = $e->getMessage();
        if (strpos($errorMsg, 'timed out') !== false || strpos($errorMsg, 'timeout') !== false) {
            echo "<strong>🔍 Diagnóstico:</strong> Error de timeout<br>";
            echo "<strong>💡 Posibles soluciones:</strong><br>";
            echo "• Verificar conectividad a internet<br>";
            echo "• Comprobar configuración de firewall<br>";
            echo "• Verificar que el servidor de BD esté activo<br>";
            echo "• Revisar configuración de red/proxy<br>";
        } elseif (strpos($errorMsg, 'Access denied') !== false) {
            echo "<strong>🔍 Diagnóstico:</strong> Credenciales incorrectas<br>";
            echo "<strong>💡 Solución:</strong> Verificar usuario y contraseña<br>";
        } elseif (strpos($errorMsg, 'Unknown database') !== false) {
            echo "<strong>🔍 Diagnóstico:</strong> Base de datos no existe<br>";
            echo "<strong>💡 Solución:</strong> Verificar nombre de la base de datos<br>";
        }
        echo "</div>";
        
        return false;
    }
    echo "</div>";
    
    // Si la conexión fue exitosa, mostrar información adicional
    if ($conexion) {
        // Información del servidor
        echo "<div style='background: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;'>";
        echo "<h3 style='color: #333; margin-top: 0;'>🖥️ Información del Servidor</h3>";
        echo "<p><strong>Versión de MySQL:</strong> " . mysqli_get_server_info($conexion) . "</p>";
        echo "<p><strong>Versión del Cliente:</strong> " . mysqli_get_client_info() . "</p>";
        echo "<p><strong>Protocolo:</strong> " . mysqli_get_proto_info($conexion) . "</p>";
        echo "<p><strong>Host Info:</strong> " . mysqli_get_host_info($conexion) . "</p>";
        echo "<p><strong>Charset:</strong> " . mysqli_character_set_name($conexion) . "</p>";
        echo "</div>";
        
        // Prueba de consulta básica
        echo "<div style='background: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;'>";
        echo "<h3 style='color: #333; margin-top: 0;'>🔍 Prueba de Consulta</h3>";
        
        try {
            $consulta = "SELECT DATABASE() as base_actual, NOW() as fecha_hora, VERSION() as version, CONNECTION_ID() as connection_id";
            $resultado = mysqli_query($conexion, $consulta);
            
            if ($resultado) {
                $fila = mysqli_fetch_assoc($resultado);
                echo "<div style='background: #d4edda; color: #155724; padding: 12px; border-radius: 6px; border: 1px solid #c3e6cb; margin-bottom: 10px;'>";
                echo "<strong>✅ Consulta ejecutada correctamente</strong>";
                echo "</div>";
                echo "<p><strong>Base de datos actual:</strong> " . htmlspecialchars($fila['base_actual']) . "</p>";
                echo "<p><strong>Fecha y hora del servidor:</strong> " . htmlspecialchars($fila['fecha_hora']) . "</p>";
                echo "<p><strong>Versión MySQL:</strong> " . htmlspecialchars($fila['version']) . "</p>";
                echo "<p><strong>ID de Conexión:</strong> " . htmlspecialchars($fila['connection_id']) . "</p>";
            }
        } catch (Exception $e) {
            echo "<div style='background: #f8d7da; color: #721c24; padding: 12px; border-radius: 6px; border: 1px solid #f5c6cb;'>";
            echo "<strong>❌ Error en la consulta:</strong><br>";
            echo htmlspecialchars($e->getMessage());
            echo "</div>";
        }
        echo "</div>";
        
        // Listar tablas
        echo "<div style='background: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;'>";
        echo "<h3 style='color: #333; margin-top: 0;'>📊 Tablas Disponibles</h3>";
        
        try {
            $consulta_tablas = "SHOW TABLES";
            $resultado_tablas = mysqli_query($conexion, $consulta_tablas);
            
            if ($resultado_tablas && mysqli_num_rows($resultado_tablas) > 0) {
                echo "<div style='background: #d4edda; color: #155724; padding: 12px; border-radius: 6px; border: 1px solid #c3e6cb; margin-bottom: 10px;'>";
                echo "<strong>✅ Se encontraron " . mysqli_num_rows($resultado_tablas) . " tabla(s)</strong>";
                echo "</div>";
                echo "<ul style='margin: 0; padding-left: 20px; columns: 2;'>";
                while ($tabla = mysqli_fetch_array($resultado_tablas)) {
                    echo "<li>" . htmlspecialchars($tabla[0]) . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<div style='background: #fff3cd; color: #856404; padding: 12px; border-radius: 6px; border: 1px solid #ffeaa7;'>";
                echo "<strong>⚠️ No se encontraron tablas en la base de datos</strong>";
                echo "</div>";
            }
        } catch (Exception $e) {
            echo "<div style='background: #f8d7da; color: #721c24; padding: 12px; border-radius: 6px; border: 1px solid #f5c6cb;'>";
            echo "<strong>❌ Error al listar tablas:</strong><br>";
            echo htmlspecialchars($e->getMessage());
            echo "</div>";
        }
        echo "</div>";
        
        // Cerrar conexión
        mysqli_close($conexion);
    }
    
    // Recomendaciones
    echo "<div style='background: #e7f3ff; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #0066cc;'>";
    echo "<h3 style='color: #0066cc; margin-top: 0;'>💡 Recomendaciones</h3>";
    echo "<ul style='margin: 0; padding-left: 20px;'>";
    echo "<li><strong>Para producción:</strong> Aumentar el timeout si es necesario</li>";
    echo "<li><strong>Seguridad:</strong> Usar variables de entorno para credenciales</li>";
    echo "<li><strong>Rendimiento:</strong> Implementar pool de conexiones</li>";
    echo "<li><strong>Monitoreo:</strong> Registrar errores en logs</li>";
    echo "<li><strong>Backup:</strong> Configurar servidor de respaldo</li>";
    echo "</ul>";
    echo "</div>";
    
    echo "<div style='background: #e2e3e5; color: #383d41; padding: 12px; border-radius: 6px; text-align: center;'>";
    echo "<strong>🔒 Diagnóstico completado</strong>";
    echo "</div>";
    
    echo "</div>";
    
    return $conexion !== null;
}

// Función para verificar conectividad del host
function checkHostReachability($host, $port, $timeout = 5) {
    $connection = @fsockopen($host, $port, $errno, $errstr, $timeout);
    if ($connection) {
        fclose($connection);
        return true;
    }
    return false;
}

// Función simple para conexión (para usar en otros archivos)
function conectarBaseDatos() {
    global $host, $usuario, $contrasena, $baseDeDatos, $puerto;
    
    try {
        $conexion = mysqli_connect($host, $usuario, $contrasena, $baseDeDatos, $puerto);
        
        if (!$conexion) {
            throw new Exception("Error de conexión: " . mysqli_connect_error());
        }
        
        return $conexion;
        
    } catch (Exception $e) {
        error_log("Error de conexión a BD: " . $e->getMessage());
        return false;
    }
}

// Ejecutar diagnóstico si se accede directamente
if (basename($_SERVER['PHP_SELF']) == 'prueba_conexion.php') {
    probarConexionMejorada();
}
?>
