<?php
$host = "localhost";
$usuario = "root";
$contrasena = "Ramirez034";
$baseDeDatos = "comercializadora";

$conexion = mysqli_connect($host, $usuario, $contrasena, $baseDeDatos);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

mysqli_set_charset($conexion, "utf8mb4");
?>