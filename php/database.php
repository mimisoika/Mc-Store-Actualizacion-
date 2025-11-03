<?php
//Script de coneccion a mysql
$servidor = "localhost";
$usuario = "root";
$password = "root";
$bd = "comercializadora";
//linea de conexxion a bd
$conexion = new mysqli($servidor, $usuario, $password, $bd);

if($conexion->connect_error){
    die("Error de conexion:" . $conexion->connect_error);
}
?>