<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
$email=$_POST['email'];/* Obtiene el valor del campo de entrada usuario del formulario enviado por el método POST.*/
$pass=$_POST['pass'];/* Obtiene el valor del campo de entrada password del formulario enviado por el método POST.*/

include("conexion.php");/* Incluye el archivo conexion.php, que generalmente contiene el código para conectar a la base de datos. 
Esto permite que el script tenga acceso a la conexión a la base de datos.*/

// Verificar la contraseña
$pass_hashed = sha1($pass);

$consulta = mysqli_query($conexion, "SELECT ID_Cuenta, ID_Paciente, ID_Profesional, ID_Tipo FROM cuentas WHERE Mail='$email' AND password='$pass_hashed'");
$resultado = mysqli_num_rows($consulta);	


if($resultado > 0){/*Comienza una estructura condicional que verifica si hay al menos 
	un resultado en la consulta (es decir, si el usuario existe)*/

	$respuesta=mysqli_fetch_array(result: $consulta);
	/* Extrae una fila de resultados de la consulta y la almacena como un array asociativo en $respuesta*/

	$_SESSION['ID_Tipo'] = $respuesta['ID_Tipo'];
	$_SESSION['ID_Cuenta'] = $respuesta['ID_Cuenta'];
		if($respuesta['ID_Tipo']==1){

			$consulta2 = mysqli_query($conexion, "SELECT Nombre, Apellido FROM pacientes WHERE ID_Paciente = " . $respuesta['ID_Paciente']);
			$respuesta2=mysqli_fetch_array(result: $consulta2);
			$_SESSION['Nombre']=$respuesta2['Nombre'];/*Almacena el nombre del usuario en la sesión*/
			$_SESSION['Apellido']=$respuesta2['Apellido'];/* Almacena el apellido del usuario en la sesión*/
		
		}elseif($respuesta['ID_Tipo']==2){
		
			$consulta2 = mysqli_query($conexion, "SELECT Nombre, Apellido FROM doctores WHERE ID_Profesional = " . $respuesta['ID_Profesional']);
			$respuesta2=mysqli_fetch_array(result: $consulta2);
			$_SESSION['Nombre']=$respuesta2['Nombre'];/*Almacena el nombre del usuario en la sesión*/
			$_SESSION['Apellido']=$respuesta2['Apellido'];/* Almacena el apellido del usuario en la sesión*/
		}  
		echo "<script>
		alert('Usuario registrado exitosamente');
		window.location.href = 'index.php';
		</script>";
		exit();
	} else {
        echo "<script>alert('Las credenciales son incorrectas: Usuario o contraseña no válidos');
		window.location.href = 'form_login.php';
		</script>";
    }
}
?>