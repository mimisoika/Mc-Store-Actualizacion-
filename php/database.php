<?php
//Script de coneccion a mysql
$servidor = "31.220.96.192";
$usuario = "admin_comercial@MC";
$password = "ComerzialMC@12";
$bd = "comercializadora";
//linea de conexxion a bd
$conexion = new mysqli($servidor, $usuario, $password, $bd);

if($conexion->connect_error){
    die("Error de conexion:" . $conexion->connect_error);
}
?>