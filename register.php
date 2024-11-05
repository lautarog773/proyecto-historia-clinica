<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("conexion.php");
if (!$conexion) {
  die("Error en la conexión: " . mysqli_connect_error());
}

$nombre = htmlspecialchars($_POST['nombre']);
$apellido = htmlspecialchars($_POST['apellido']);
$dni = htmlspecialchars($_POST['dni']);
$obrasocial = filter_input(INPUT_POST, 'obrasocial', FILTER_VALIDATE_INT);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$pass = sha1($_POST['pass']);

// Debug: mostrar los valores capturados
//var_dump($nombre, $apellido, $dni, $obrasocial, $email, $pass);

	/*if ($_POST['tyc'] === "") {
		$tyc="no";
	} else {
		$tyc="si";
	}*/

  if (!$nombre || !$apellido || !$dni || !$obrasocial || !$email || !$pass) {
    die("Datos inválidos. Por favor, verifique la información e intente nuevamente.");
  }
/*
  $consulta = mysqli_query($conexion, "INSERT INTO pacientes (Nombre, Apellido, DNI, ID_OS) 
  VALUES('$nombre','$apellido','$dni', '$obrasocial'");
  $consulta2 = mysqli_query($conexion, "INSERT INTO cuentas (ID_Paciente, ID_Tipo, Password, Mail) 
  VALUES('$id_paciente', 1, '$pass', '$email'");
*/
  try {
    $conexion->begin_transaction();

    // Insertar en la tabla de pacientes
    $stmt1 = $conexion->prepare("INSERT INTO pacientes (Nombre, Apellido, DNI, ID_OS) VALUES (?, ?, ?, ?)");
    if (!$stmt1) {
      throw new Exception("Error en la preparación de la consulta de pacientes: " . $conexion->error);
    }
    $stmt1->bind_param("sssi", $nombre, $apellido, $dni, $obrasocial);
    $stmt1->execute();
if ($stmt1->error) {
    die("Error en la consulta de pacientes: " . $stmt1->error);
}
    $id_paciente = $conexion->insert_id; // Obtener el ID del paciente recién insertado
    if (!$id_paciente) {
      throw new Exception("Error al obtener el ID de paciente.");
    }
    // Insertar en la tabla de cuentas
    $stmt2 = $conexion->prepare("INSERT INTO cuentas (ID_Paciente, ID_Tipo, Password, Mail) VALUES (?, ?, ?, ?)");
    if (!$stmt2) {
      throw new Exception("Error en la preparación de la consulta de cuentas: " . $conexion->error);
    }
    $id_tipo = 1; // Tipo de usuario por defecto "paciente"
    $stmt2->bind_param("iiss", $id_paciente, $id_tipo, $pass, $email);
    $stmt2->execute();
if ($stmt2->error) {
    die("Error en la consulta de cuentas: " . $stmt2->error);
}

    // Confirmar la transacción
    $conexion->commit();

    echo "<script>alert('Usuario registrado exitosamente');</script>";
    header("Location: form_login.php");
    exit();
} catch (Exception $e) {
    $conexion->rollback(); // Revertir la transacción en caso de error
    echo "<script>alert('No se pudo registrar el usuario: " . $e->getMessage() . "');</script>";
}
// Cerrar las conexiones
if (isset($stmt1)) {
  $stmt1->close();
}
if (isset($stmt2)) {
  $stmt2->close();
}
/*
$consulta->close();
$consulta2->close();*/
$conexion->close();

?>