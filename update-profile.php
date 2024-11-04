<?php
include 'conexion.php';
session_start();

$userId = $_SESSION['ID_Cuenta'];
$field = $_POST['field'];
$newValue = $_POST['fieldValue'];

// verificar que el campo y el valor sean válidos
if (in_array($field, ['Nombre', 'Apellido', 'DNI', 'mail']) && !empty($newValue)) {
    // paciente o profesional
    $query = "SELECT ID_Paciente, ID_Profesional FROM cuentas WHERE ID_Cuenta = '$userId'";
    $result = $conexion->query($query);
    $user = $result->fetch_assoc();

    if ($user['ID_Paciente']) {
        // paciente, actualizar en la tabla 'pacientes'
        $patientId = $user['ID_Paciente'];
        $updateQuery = "UPDATE pacientes SET $field = ? WHERE ID_Paciente = ?";
        $stmt = $conexion->prepare($updateQuery);
        $stmt->bind_param('si', $newValue, $patientId);
    } elseif ($user['ID_Profesional']) {
        // profesional, actualizar en la tabla 'doctores'
        $doctorId = $user['ID_Profesional'];
        $updateQuery = "UPDATE doctores SET $field = ? WHERE ID_Profesional = ?";
        $stmt = $conexion->prepare($updateQuery);
        $stmt->bind_param('si', $newValue, $doctorId);
    }

    
    if ($stmt->execute()) {
        // redirigir a la página de perfil con un mensaje de éxito
        $_SESSION['message'] = "Campo actualizado exitosamente";
        header("Location: perfil.php");
        exit();
    } else {
        // error en la actualización
        $_SESSION['error'] = "Error al actualizar el campo";
        header("Location: perfil.php");
        exit();
    }
} else {
    // no válido o valor vacío
    $_SESSION['error'] = "Campo no válido o valor vacío";
    header("Location: perfil.php");
    exit();
}
?>
