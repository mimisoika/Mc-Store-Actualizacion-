<?php
$host = "31.220.96.192";
$usuario = "admin_comercial";
$contrasena = "ComerzialMC@12";
$baseDeDatos = "comercializadora";

$conexion = mysqli_connect($host, $usuario, $contrasena, $baseDeDatos);

// Verificar si la conexión fue exitosa
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Establecer el juego de caracteres a UTF-8 para evitar problemas con tildes y caracteres especiales
mysqli_set_charset($conexion, "utf8mb4");
?>
