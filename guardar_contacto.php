<?php
include 'conexion.php';
session_start(); // Asegurarse de iniciar sesión para usar variables de sesión

// Recibir los datos del formulario
$nombre = $_POST['name'];
$email = $_POST['email'];
$asunto = $_POST['subject'];
$mensaje = $_POST['message'];

// Validar que todos los campos están completos
if (!empty($nombre) && !empty($email) && !empty($asunto) && !empty($mensaje)) {
    
    // Preparar la consulta para insertar los datos en la tabla 'contactos'
    $query = "INSERT INTO contactos (Nombre, Mail, Asunto, Mensaje) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($query);
    
    if ($stmt) {
        $stmt->bind_param("ssss", $nombre, $email, $asunto, $mensaje);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Mensaje de éxito en la sesión
            $_SESSION['message'] = "Su mensaje ha sido enviado correctamente.";
        } else {
            // Error al ejecutar la consulta
            $_SESSION['error'] = "Error al enviar el mensaje. Intente nuevamente.";
        }
        $stmt->close();
    } else {
        // Error al preparar la consulta
        $_SESSION['error'] = "Error en el servidor. Intente nuevamente.";
    }
} else {
    // Redirigir con mensaje de error si faltan datos
    $_SESSION['error'] = "Todos los campos son obligatorios.";
}

// Cerrar la conexión a la base de datos
$conexion->close();

// Redirigir de vuelta a contact.php
header("Location: contact.php");
exit();
?>
