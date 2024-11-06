<?php
// Datos de conexión
$host = "localhost"; 
$usuario = "root"; 
$password = ""; 
<<<<<<< HEAD
$base_datos = "proyecto_historia_clinica_v1";
=======
$base_datos = "proyecto_historia_clinica_v3";
>>>>>>> 2fc650c4abddd566d2ff2095daf49b052c29cce7

// Crear conexión
$conexion = new mysqli($host, $usuario, $password, $base_datos);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>
