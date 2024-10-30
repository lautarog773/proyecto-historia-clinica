<?php
include "conexion.php";

// Verificar si se envió un ID válido
if (isset($_GET['id'])) {
    $id_cuenta = intval($_GET['id']);

    // Preparar la consulta de eliminación con una sentencia preparada para evitar SQL Injection
    $stmt = $conexion->prepare("DELETE FROM cuentas WHERE ID_Cuenta = ?");
    $stmt->bind_param("i", $id_cuenta);

    // Ejecutar la consulta y verificar si se eliminó correctamente
    if ($stmt->execute()) {
        echo "<script>alert('Cuenta eliminada exitosamente');</script>";
    } else {
        echo "<script>alert('Error al eliminar la cuenta');</script>";
    }

    $stmt->close();
}

// Redirigir de vuelta a la lista de cuentas
echo "<script>window.location.href = 'crud_cuentas.php';</script>";
?>
