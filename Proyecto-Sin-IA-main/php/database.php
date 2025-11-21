<?php
$host = "localhost";
$usuario = "root";
$contrasena = "Ramirez034";
$baseDeDatos = "comercializadora";
$puerto = 3306;

$conexion = mysqli_connect($host, $usuario, $contrasena, $baseDeDatos, $puerto);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
//prueba

mysqli_set_charset($conexion, "utf8mb4");
?>


