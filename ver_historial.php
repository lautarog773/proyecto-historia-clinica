<?php
session_start();
include 'conexion.php'; // Conexión a la base de datos

// TEST ONLY
$_SESSION['ID_Cuenta'] = 30;

// Verificar si el usuario es un doctor
if (!isset($_SESSION['ID_Cuenta']) || !esDoctor($_SESSION['ID_Cuenta'], $conexion)) {
    header("Location: index.php");
    exit();
}

// Función para verificar si el usuario es un doctor
function esDoctor($id_cuenta, $conexion)
{

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


$id_paciente = (int)$_POST['id_paciente'];


// Consulta para obtener las consultas médicos del paciente


$sql_consultas = "SELECT d.id_profesional as id_doctor, d.nombre as nombre_doctor, d.apellido as apellido_doctor,
    cm.Motivo as motivo, cm.Tratamiento as tratamiento, cm.Diagnostico as diagnostico,
    cm.Comentarios as comentarios, cm.Fecha as fecha, e.Nombre as especialidad, e.ID_Especialidad as id_especialidad,
    cm.id_consulta as id_consulta
    FROM consultas_medicas cm
    LEFT JOIN cuentas c ON c.ID_Paciente = cm.ID_Paciente
    LEFT JOIN pacientes p ON c.ID_Paciente = p.ID_Paciente
    LEFT JOIN doctores d ON cm.ID_Profesional = d.ID_Profesional
    LEFT JOIN especialidades e ON d.ID_Especialidad = e.ID_Especialidad
    WHERE c.ID_Paciente = $id_paciente
    ORDER BY cm.Fecha DESC";


$result_consultas = mysqli_query($conexion, $sql_consultas);

$historial_consultas = [];
if ($result_consultas->num_rows > 0) {
    while ($consulta = $result_consultas->fetch_assoc()) {
        $historial_consultas[] = $consulta;
    }
}
$_SESSION['historial_consultas'] = $historial_consultas;



// Consulta para obtener los estudios médicos del paciente

$sql_estudios = "SELECT em.Fecha, es.nombre AS especialidad, em.Imagenes, em.Informe, cm.id_consulta AS id_consulta, cm.motivo AS motivo
FROM estudios_medicos em
INNER JOIN especialidades es ON em.ID_Especialidad = es.ID_Especialidad
INNER JOIN consultas_medicas cm ON em.ID_Consulta = cm.ID_Consulta
WHERE em.ID_Consulta IN (SELECT ID_Consulta FROM consultas_medicas WHERE ID_Paciente = $id_paciente)";

$result_estudios = mysqli_query($conexion, $sql_estudios);

$historial_estudios = [];
if ($result_estudios->num_rows > 0) {
    while ($estudio = $result_estudios->fetch_assoc()) {
        $historial_estudios[] = $estudio;
    }
}
$_SESSION['historial_estudios'] = $historial_estudios;

$_SESSION['tab_activa'] = 'historial';

mysqli_close($conexion);
header("Location: consulta.php");
exit();
?>