<?php
include 'conexion.php';
session_start();

$userId = $_SESSION['ID_Cuenta'];
$field = $_POST['field'];
$newValue = $_POST['fieldValue'];

// campos permitidos para actualizar
$allowedFields = ['Nombre', 'Apellido', 'ObraSocial', 'mail'];

// valor válido
if (in_array($field, $allowedFields) && !empty($newValue)) {
    
    // validación formato de correo electrónico
    if ($field === 'mail' && !filter_var($newValue, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Formato de correo electrónico no válido.";
        header("Location: perfil.php");
        exit();
    }

    // paciente o profesional
    $query = "SELECT ID_Paciente, ID_Profesional FROM cuentas WHERE ID_Cuenta = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // campo según corresponda
    if ($field === 'mail') {
        // correo en la tabla 'cuentas'
        $updateQuery = "UPDATE cuentas SET mail = ? WHERE ID_Cuenta = ?";
        $stmt = $conexion->prepare($updateQuery);
        if (!$stmt) {
            $_SESSION['error'] = "Error al preparar la consulta para actualizar el correo.";
            header("Location: perfil.php");
            exit();
        }
        $stmt->bind_param('si', $newValue, $userId);
    } elseif ($field === 'ObraSocial') {
        // ID_OS basado en el nombre de la obra social
        $os_query = "SELECT ID_OS FROM obras_sociales WHERE Nombre = ?";
        $os_stmt = $conexion->prepare($os_query);
        $os_stmt->bind_param("s", $newValue);
        $os_stmt->execute();
        $os_result = $os_stmt->get_result();
        $obraSocial = $os_result->fetch_assoc();

        // obra social válida
        if (!$obraSocial) {
            $_SESSION['error'] = "Obra Social no válida.";
            header("Location: perfil.php");
            exit();
        }

        $newValue = $obraSocial['ID_OS'];  // Cambiar $newValue al ID_OS correspondiente
        $field = 'ID_OS';  // Cambiar el campo a ID_OS para la actualización en la base de datos
    }

    // actualización en función del tipo de usuario y campo
    if ($field !== 'mail') {
        if ($user['ID_Paciente']) {
            // paciente
            $patientId = $user['ID_Paciente'];
            $updateQuery = "UPDATE pacientes SET $field = ? WHERE ID_Paciente = ?";
            $stmt = $conexion->prepare($updateQuery);
            if (!$stmt) {
                $_SESSION['error'] = "Error al preparar la consulta para paciente.";
                header("Location: perfil.php");
                exit();
            }
            if ($field === 'ID_OS') {
                $stmt->bind_param('ii', $newValue, $patientId);
            } else {
                $stmt->bind_param('si', $newValue, $patientId);
            }
        } elseif ($user['ID_Profesional']) {
            // profesional
            $doctorId = $user['ID_Profesional'];
            $updateQuery = "UPDATE doctores SET $field = ? WHERE ID_Profesional = ?";
            $stmt = $conexion->prepare($updateQuery);
            if (!$stmt) {
                $_SESSION['error'] = "Error al preparar la consulta para profesional.";
                header("Location: perfil.php");
                exit();
            }
            if ($field === 'ID_OS') {
                $stmt->bind_param('ii', $newValue, $doctorId);
            } else {
                $stmt->bind_param('si', $newValue, $doctorId);
            }
        }
    }

    // verificar el resultado
    if ($stmt->execute()) {
        $_SESSION['message'] = "Campo actualizado exitosamente";
        header("Location: perfil.php");
        exit();
    } else {
        $_SESSION['error'] = "Error al ejecutar la actualización.";
        header("Location: perfil.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Campo no válido o valor vacío.";
    header("Location: perfil.php");
    exit();
}
?>

