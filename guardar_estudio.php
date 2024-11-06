<?php
session_start();
// Conexión a la base de datos
include 'conexion.php'; // Archivo con la conexión a la base de datos

// TEST ONLY
//$_SESSION['ID_Cuenta'] = 30;

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

// Verificar si se han enviado los datos necesarios
if (isset($_POST['id_consulta'], $_POST['id_especialidad'], $_POST['fecha'], $_POST['informe'])) {
    // Recibir los datos del formulario
    $id_consulta = $_POST['id_consulta'];
    $id_especialidad = $_POST['id_especialidad'];
    $fecha = $_POST['fecha'];
    $informe = $_POST['informe'];

    // Procesar la imagen subida
    $ruta_imagen = '';
    if (!empty($_FILES['imagen']['name'])) {
        $ruta_imagenes = 'uploads/estudios/'; // Carpeta para almacenar las imágenes
        if (!is_dir($ruta_imagenes)) {
            mkdir($ruta_imagenes, 0777, true);
        }

        $nombre_archivo = basename($_FILES['imagen']['name']);
        $ruta_imagen = $ruta_imagenes . uniqid() . '_' . $nombre_archivo;

        // Mover archivo al directorio de destino
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_imagen)) {
            // La ruta de la imagen ya está almacenada en $ruta_imagen
        } else {
            echo "Error al cargar la imagen.";
            exit;
        }
    }

    // Preparar la consulta SQL
    $sql = "INSERT INTO estudios_medicos (ID_Consulta, ID_Especialidad, Fecha, Imagenes, Informe)
    VALUES ('$id_consulta', '$id_especialidad', '$fecha', '$ruta_imagen', '$informe')";

    if (mysqli_query($conexion, $sql)) {
        $_SESSION['consulta_result'] = "Estudio guardado correctamente.";
    } else {
        $_SESSION['consulta_result'] = "Error al guardar el estudio";
    }

    mysqli_close($conexion);
    header("Location: consulta.php");
    exit();

} else {
    echo "Faltan datos necesarios para registrar el estudio.";
}
