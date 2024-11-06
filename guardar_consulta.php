<?php
session_start();
require 'conexion.php';

// TEST ONLY
//$_SESSION['ID_Cuenta'] = 30;

// Verificar si el usuario es un doctor
if (!isset($_SESSION['ID_Cuenta']) || !esDoctor($_SESSION['ID_Cuenta'], $conexion)) {
    header("Location: index.php");
    exit();
}

// Función para verificar si el usuario es un doctor
function esDoctor($id_cuenta, $conexion) {

    $sql = "SELECT ID_Tipo, ID_Profesional FROM cuentas WHERE ID_Cuenta = ?";
    $stmt = mysqli_prepare($conexion, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id_cuenta);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {

            $_SESSION['ID_Profesional'] = $row['ID_Profesional'];
            return $row['ID_Tipo'] == 2;
        }
    }
    return false;
}




// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $motivo = $_POST['motivo'];
    $diagnostico = $_POST['diagnostico'];
    $tratamiento = $_POST['tratamiento'];
    $comentarios = $_POST['comentarios'];
    $id_paciente = $_POST['id_paciente'];
    $id_profesional = $_SESSION['ID_Profesional'];
    $fecha = $_POST['fecha'];

    // Preparar la consulta SQL
    $sql = "INSERT INTO consultas_medicas (motivo, diagnostico, tratamiento, comentarios, ID_Paciente, ID_Profesional, fecha) VALUES ('$motivo', '$diagnostico', '$tratamiento', '$comentarios', $id_paciente, $id_profesional, '$fecha')";

    if (mysqli_query($conexion, $sql)) {
        $_SESSION['consulta_result'] = "Consulta médica guardada correctamente.";
    } else {
        $_SESSION['consulta_result'] = "Error al guardar la consulta";
    }

    mysqli_close($conexion);
    header("Location: consulta.php");
    exit();


}
?>
