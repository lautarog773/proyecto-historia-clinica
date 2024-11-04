<?php
	include("conexion.php");

$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
$apellido = filter_input(INPUT_POST, 'apellido', FILTER_SANITIZE_STRING);
$dni = filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_STRING);
$obrasocial = filter_input(INPUT_POST, 'obrasocial', FILTER_VALIDATE_INT);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$pass = sha1($_POST['pass']);

	/*if ($_POST['tyc'] === "") {
		$tyc="no";
	} else {
		$tyc="si";
	}*/

  if (!$nombre || !$apellido || !$dni || !$obrasocial || !$email || !$pass) {
    die("Datos inválidos. Por favor, verifique la información e intente nuevamente.");
  }

  $consulta = mysqli_query($conexion, "INSERT INTO pacientes (Nombre, Apellido, DNI, ID_OS) 
  VALUES('$nombre','$apellido','$dni', '$obrasocial'");
  $consulta2 = mysqli_query($conexion, "INSERT INTO cuentas (ID_Paciente, ID_Tipo, Password, Mail) 
  VALUES('$id_paciente', 1, '$pass', '$email'");

  /*
  try {
    $conexion->begin_transaction();

    // Insertar en la tabla de pacientes
    $stmt1 = $conexion->prepare("INSERT INTO pacientes (Nombre, Apellido, DNI, ID_OS) VALUES (?, ?, ?, ?)");
    $stmt1->bind_param("ssii", $nombre, $apellido, $dni, $obrasocial);
    $stmt1->execute();
    $id_paciente = $conexion->insert_id; // Obtener el ID del paciente recién insertado

    // Insertar en la tabla de cuentas
    $stmt2 = $conexion->prepare("INSERT INTO cuentas (ID_Paciente, ID_Tipo, Password, Mail) VALUES (?, ?, ?, ?)");
    $id_tipo = 1; // Tipo de usuario por defecto
    $stmt2->bind_param("iiss", $id_paciente, $id_tipo, $pass, $email);
    $stmt2->execute();

    // Confirmar la transacción
    $conexion->commit();

    echo "Usuario registrado exitosamente";
} catch (Exception $e) {
    $conexion->rollback(); // Revertir la transacción en caso de error
    echo "<script>alert('No se pudo registrar el usuario. Inténtelo nuevamente');</script>";
}
// Cerrar las conexiones
$stmt1->close();
$stmt2->close();
*/
/*
$consulta->close();
$consulta2->close();
$conexion->close();*/
header("Location:form_login.php");

?>