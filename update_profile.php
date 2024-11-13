<?php
include 'conexion.php';
session_start();

$userId = $_SESSION['ID_Cuenta'];
$field = $_POST['field'];
$newValue = $_POST['fieldValue'];

// Campos permitidos para actualizar
$allowedFields = ['Nombre', 'Apellido', 'ObraSocial', 'mail', 'Especialidad'];

// Verificar si el campo es válido y el valor no está vacío
if (in_array($field, $allowedFields) && !empty($newValue)) {
    
    // Validar el formato de correo electrónico si se trata del campo 'mail'
    if ($field === 'mail' && !filter_var($newValue, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Formato de correo electrónico no válido.";
        header("Location: perfil.php");
        exit();
    }

    // Obtener si el usuario es un paciente o un profesional
    $query = "SELECT ID_Paciente, ID_Profesional FROM cuentas WHERE ID_Cuenta = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Actualizar el campo correspondiente
    if ($field === 'mail') {
        // Actualizar el correo en la tabla 'cuentas'
        $updateQuery = "UPDATE cuentas SET mail = ? WHERE ID_Cuenta = ?";
        $stmt = $conexion->prepare($updateQuery);
        if (!$stmt) {
            $_SESSION['error'] = "Error al preparar la consulta para actualizar el correo.";
            header("Location: perfil.php");
            exit();
        }
        $stmt->bind_param('si', $newValue, $userId);

    } elseif ($field === 'ObraSocial') {
        // Obtener el ID_OS basado en el nombre de la obra social
        $os_query = "SELECT ID_OS FROM obras_sociales WHERE Nombre = ?";
        $os_stmt = $conexion->prepare($os_query);
        $os_stmt->bind_param("s", $newValue);
        $os_stmt->execute();
        $os_result = $os_stmt->get_result();
        $obraSocial = $os_result->fetch_assoc();

        // Verificar si la obra social es válida
        if (!$obraSocial) {
            $_SESSION['error'] = "Obra Social no válida.";
            header("Location: perfil.php");
            exit();
        }

        $newValue = $obraSocial['ID_OS'];
        $field = 'ID_OS';

    } elseif ($field === 'Especialidad') {
        // Obtener el ID_Especialidad basado en el nombre de la especialidad
        $especialidad_query = "SELECT ID_Especialidad FROM especialidades WHERE Nombre = ?";
        $especialidad_stmt = $conexion->prepare($especialidad_query);
        $especialidad_stmt->bind_param("s", $newValue);
        $especialidad_stmt->execute();
        $especialidad_result = $especialidad_stmt->get_result();
        $especialidad = $especialidad_result->fetch_assoc();

        // Verificar si la especialidad es válida
        if (!$especialidad) {
            $_SESSION['error'] = "Especialidad no válida.";
            header("Location: perfil.php");
            exit();
        }

        $newValue = $especialidad['ID_Especialidad'];
        $field = 'ID_Especialidad';
    }

    // Actualizar el campo en la tabla correspondiente
    if ($field !== 'mail') {
        if ($user['ID_Paciente']) {
            // Actualizar para pacientes
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
            // Actualizar para profesionales
            $doctorId = $user['ID_Profesional'];
            $updateQuery = "UPDATE doctores SET $field = ? WHERE ID_Profesional = ?";
            $stmt = $conexion->prepare($updateQuery);
            if (!$stmt) {
                $_SESSION['error'] = "Error al preparar la consulta para profesional.";
                header("Location: perfil.php");
                exit();
            }
            if ($field === 'ID_Especialidad') {
                $stmt->bind_param('ii', $newValue, $doctorId);
            } else {
                $stmt->bind_param('si', $newValue, $doctorId);
            }
        }
    }

    // Ejecutar la actualización
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
