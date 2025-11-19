<?php
$host = "31.220.96.192";
$usuario = "admin_comercial";
$contrasena = "ComerzialMC@12";
$baseDeDatos = "comercializadora";

$conexion = mysqli_connect($host, $usuario, $contrasena, $baseDeDatos);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
//prueba

mysqli_set_charset($conexion, "utf8mb4");
?>


