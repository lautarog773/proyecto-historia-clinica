<?php
include 'conexion.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $dni = $_POST['dni'];
    $new_password = sha1($_POST['new_password']); 

    // verificar si el correo existe
    $sql_cuenta = "SELECT * FROM cuentas WHERE mail = '$email'";
    $result_cuenta = $conexion->query($sql_cuenta);

    if ($result_cuenta->num_rows > 0) {
        $cuenta = $result_cuenta->fetch_assoc();
        $id_paciente = $cuenta['ID_Paciente'];
        $id_profesional = $cuenta['ID_Profesional'];

        // verificar si es paciente o doctor y validar el DNI
        if ($id_paciente) {
            $sql_dni = "SELECT * FROM pacientes WHERE ID_Paciente = '$id_paciente' AND dni = '$dni'";
        } else {
            $sql_dni = "SELECT * FROM doctores WHERE ID_Profesional = '$id_profesional' AND dni = '$dni'";
        }

        $result_dni = $conexion->query($sql_dni);

        if ($result_dni->num_rows > 0) {
            // actualizar la contraseña en la tabla "cuentas"
            $update_sql = "UPDATE cuentas SET password = '$new_password' WHERE mail = '$email'";

            if ($conexion->query($update_sql) === TRUE) {
                header("Location: recover-password.php?status=success");
                exit();
            } else {
                header("Location: recover-password.php?status=error");
                exit();
            }
        } else {
            header("Location: recover-password.php?status=error");
            exit();
        }
    } else {
        header("Location: recover-password.php?status=error");
        exit();
    }
}
?>
