<?php
// Configuración de la conexión a la base de datos local
$host = "localhost";
$usuario = "root";
$contrasena = "Ramirez034";
$baseDeDatos = "comercializadora";
$puerto = 3306;

// Establecer la conexión usando el procedimiento de MySQLi
$conexion = mysqli_connect($host, $usuario, $contrasena, $baseDeDatos, $puerto);

// Verificar si la conexión fue exitosa
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Establecer el juego de caracteres a UTF-8 para evitar problemas con tildes y caracteres especiales
mysqli_set_charset($conexion, "utf8mb4");
?>
