<?php
// Datos de conexión
$host = "localhost"; 
$usuario = "root"; 
$password = ""; 
//$base_datos = "proyecto_historia_clinica_v1";
$base_datos = "proyecto_historia_clinica_v4";
//$base_datos = "proyecto_historia_clinica_v3";

// Crear conexión
$conexion = new mysqli($host, $usuario, $password, $base_datos);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>
