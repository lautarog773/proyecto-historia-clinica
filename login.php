<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
$email=$_POST['email'];/* Obtiene el valor del campo de entrada usuario del formulario enviado por el método POST.*/
$pass=$_POST['pass'];/* Obtiene el valor del campo de entrada password del formulario enviado por el método POST.*/

include("conexion.php");/* Incluye el archivo conexion.php, que generalmente contiene el código para conectar a la base de datos. 
Esto permite que el script tenga acceso a la conexión a la base de datos.*/
/*   
$consulta=mysqli_query($conexion, "SELECT ID_Cuenta, ID_Paciente, ID_Profesional, ID_Tipo FROM cuentas WHERE mail='$email' AND password='$pass'");
/*  Ejecuta una consulta SQL en la base de datos. Busca en la tabla usuarios aquellos registros donde el usuario 
y password coincidan con los valores ingresados por el usuario. El resultado se almacena en la variable $consulta.*/

	    // Verificar la contraseña
		$pass_hashed = sha1($pass);
	    $consulta = mysqli_query($conexion, "SELECT ID_Cuenta, ID_Paciente, ID_Profesional, ID_Tipo FROM cuentas WHERE mail='$email' AND password='$pass_hashed'");
    $resultado = mysqli_num_rows($consulta);	
/*$stmt = $conexion->prepare("SELECT ID_Cuenta, ID_Paciente, ID_Profesional, ID_Tipo, password FROM cuentas WHERE mail=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();


/*$resultado=mysqli_num_rows($consulta);/*Cuenta el número de filas devueltas por la consulta. 
Si hay coincidencias (es decir, si el usuario y la contraseña son correctos), el valor será mayor que cero.*/

if($resultado != 0){/*Comienza una estructura condicional que verifica si hay al menos 
	un resultado en la consulta (es decir, si el usuario existe)*/
	//$respuesta = $resultado->fetch_assoc();
	$respuesta=mysqli_fetch_array(result: $consulta);
	/* Extrae una fila de resultados de la consulta y la almacena como un array asociativo en $respuesta*/
	//$_SESSION['ID_Tipo']=$respuesta['ID_Tipo'];
	    // Verificar la contraseña
		//$hashedPass = sha1($pass); 
	//if($hashedPass === $respuesta['password']){
		$_SESSION['ID_Tipo'] = $respuesta['ID_Tipo'];
		if($respuesta['ID_Tipo']===1){
			/*$consulta2 = $conexion->prepare("SELECT Nombre, Apellido FROM pacientes WHERE ID_Paciente=?");
            $consulta2->bind_param("i", $respuesta['ID_Paciente']);
            $consulta2->execute();
            $respuesta2 = $consulta2->get_result()->fetch_assoc();
            $_SESSION['Nombre'] = $respuesta2['Nombre'];
            $_SESSION['Apellido'] = $respuesta2['Apellido'];*/
			$consulta2 = mysqli_query($conexion, "SELECT Nombre, Apellido FROM pacientes WHERE ID_Paciente = " . $respuesta['ID_Paciente']);
		$respuesta2=mysqli_fetch_array(result: $consulta2);
		$_SESSION['Nombre']=$respuesta2['Nombre'];/*Almacena el nombre del usuario en la sesión*/
		$_SESSION['Apellido']=$respuesta2['Apellido'];/* Almacena el apellido del usuario en la sesión*/
		}elseif($respuesta['ID_Tipo']===2){
			/*$consulta2 = $conexion->prepare("SELECT Nombre, Apellido FROM doctores WHERE ID_Profesional=?");
            $consulta2->bind_param("i", $respuesta['ID_Profesional']);
            $consulta2->execute();
            $respuesta2 = $consulta2->get_result()->fetch_assoc();
            $_SESSION['Nombre'] = $respuesta2['Nombre'];
            $_SESSION['Apellido'] = $respuesta2['Apellido'];*/
			$consulta2 = mysqli_query($conexion, "SELECT Nombre, Apellido FROM doctores WHERE ID_Profesional = " . $respuesta['ID_Profesional']);
		$respuesta2=mysqli_fetch_array(result: $consulta2);
		$_SESSION['Nombre']=$respuesta2['Nombre'];/*Almacena el nombre del usuario en la sesión*/
		$_SESSION['Apellido']=$respuesta2['Apellido'];/* Almacena el apellido del usuario en la sesión*/
		}  
  		header('Location: index.php');
		exit();
	} else {
        echo "<script>alert('Las credenciales son incorrectas: Contraseña no válida');</script>";
    }
}else{/* Si no hay resultados (es decir, si las credenciales no coinciden)*/
	echo "<script>alert('Las credenciales son incorrectas: Usuario no encontrado.');</script>";
}

?>