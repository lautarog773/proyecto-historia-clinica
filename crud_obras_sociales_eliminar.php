<?php
include "conexion.php";

// Verificar si se envió un ID válido
if (isset($_GET['id'])) {
    $id_os = intval($_GET['id']);

    // Preparar la consulta de eliminación con una sentencia preparada para evitar SQL Injection
    $stmt = $conexion->prepare("DELETE FROM obras_sociales WHERE ID_OS = ?");
    $stmt->bind_param("i", $id_os);

    // Ejecutar la consulta y verificar si se eliminó correctamente
    if ($stmt->execute()) {
        echo "<script>alert('Obra social eliminada exitosamente');</script>";
    } else {
        echo "<script>alert('Error al eliminar la obra social');</script>";
    }

    $stmt->close();
}

// Redirigir de vuelta a la lista de obras sociales
echo "<script>window.location.href = 'crud_obras_sociales.php';</script>";
?>
