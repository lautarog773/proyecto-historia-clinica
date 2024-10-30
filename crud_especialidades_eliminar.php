<?php
include "conexion.php";

// Verificar si se envió un ID válido
if (isset($_GET['id'])) {
    $id_especialidad = intval($_GET['id']);

    // Preparar la consulta para eliminar de manera segura
    $stmt = $conexion->prepare("DELETE FROM especialidades WHERE ID_Especialidad = ?");
    $stmt->bind_param("i", $id_especialidad);

    // Ejecutar la consulta y verificar si se eliminó correctamente
    if ($stmt->execute()) {
        echo "<script>alert('Especialidad eliminada exitosamente');</script>";
    } else {
        echo "<script>alert('Error al eliminar la especialidad');</script>";
    }

    $stmt->close();
}

// Redirigir de vuelta a la lista de especialidades
echo "<script>window.location.href = 'crud_especialidades.php';</script>";
?>
