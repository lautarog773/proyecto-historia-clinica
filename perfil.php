<?php
session_start();
require 'conexion.php';

// Verifica si el usuario está autenticado
if (!isset($_SESSION['ID_Cuenta'])) {
    header("Location: form_login.php");
    exit();
}

// Obtener información del usuario
$id_cuenta = $_SESSION['ID_Cuenta'];

// Consulta para obtener el tipo de usuario
$query = "SELECT ID_Paciente, ID_Profesional, mail FROM cuentas WHERE ID_Cuenta = '$id_cuenta'";
$result = $conexion->query($query);
$user = $result->fetch_assoc();

// Obtener opciones de obras sociales y especialidades
$os_query = "SELECT Nombre FROM obras_sociales";
$os_result = $conexion->query($os_query);
$obrasSociales = $os_result->fetch_all(MYSQLI_ASSOC);

$especialidades_query = "SELECT Nombre FROM especialidades";
$especialidades_result = $conexion->query($especialidades_query);
$especialidades = $especialidades_result->fetch_all(MYSQLI_ASSOC);

// Consulta para obtener el nombre del usuario
$sql = "SELECT c.ID_tipo, p.Nombre AS nombre_paciente, d.Nombre AS nombre_medico
        FROM cuentas c
        LEFT JOIN pacientes p ON c.ID_Paciente = p.ID_Paciente
        LEFT JOIN doctores d ON c.ID_Profesional = d.ID_Profesional
        WHERE ID_Cuenta = $id_cuenta";

// Ejecuta la consulta
$result = $conexion->query($sql);


if ($result->num_rows > 0) {
  $usuario = $result->fetch_assoc();
  $tipo_usuario = $usuario['ID_tipo'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Perfil - Historia Clínica Digital</title>
    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <!-- Fonts y CSS -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
</head>

<body class="index-page">
    <header id="header" class="header sticky-top">
        <div class="branding d-flex align-items-center">
            <div class="container position-relative d-flex align-items-center justify-content-between">
                <a href="index.php" class="logo d-flex align-items-center me-auto">
                    <h1 class="sitename">Historia Clínica Digital</h1>
                </a>
                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li><a href="index.php">Inicio</a></li>
                        <li><a href="perfil.php">Mi Perfil</a></li>
                        <li><a href="consulta.php">Consultas</a></li>
                        <?php if ($tipo_usuario == 3) : ?>
                            <li class="dropdown"><a href="crud.php"><span>Administrador</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                                <ul>
                                    <li><a href="crud_especialidades.php">Especialidades</a></li>
                                    <li><a href="crud_obras_sociales.php">Obras Sociales</a></li>
                                    <li><a href="crud_cuentas.php">Cuentas</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <li><a href="contact.php">Contacto</a></li>
                    </ul>
                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </nav>
                <a class="cta-btn d-none d-sm-block" href="logout.php">Cerrar Sesión</a>
            </div>
        </div>
    </header>
    <main class="main">
        <section class="section">
            <div class="container text-center py-4">
                <h2>Perfil de Usuario</h2>
            </div>
            <div class="container d-flex justify-content-center">
                <div class="col-md-6 col-lg-6">
                    <?php
                    if ($user['ID_Paciente']) {
                        // Perfil de paciente
                        $patientId = $user['ID_Paciente'];
                        $query = "SELECT p.Nombre, p.Apellido, p.DNI, o.Nombre AS ObraSocial 
                              FROM pacientes p 
                              JOIN obras_sociales o ON p.ID_OS = o.ID_OS 
                              WHERE p.ID_Paciente = '$patientId'";
                        $result = $conexion->query($query);
                        $profileData = $result->fetch_assoc();

                        // Obtener cantidad de estudios realizados
                        $estudios_query = "SELECT COUNT(*) AS CantidadEstudios 
                                       FROM estudios_medicos e 
                                       JOIN consultas_medicas c ON e.ID_Consulta = c.ID_Consulta 
                                       WHERE c.ID_Paciente = '$patientId'";
                        $estudios_result = $conexion->query($estudios_query);
                        $cantidadEstudios = $estudios_result->fetch_assoc()['CantidadEstudios'];

                        // Obtener cantidad de consultas realizadas
                        $consultas_query = "SELECT COUNT(*) AS CantidadConsultas 
                                        FROM consultas_medicas 
                                        WHERE ID_Paciente = '$patientId'";
                        $consultas_result = $conexion->query($consultas_query);
                        $cantidadConsultas = $consultas_result->fetch_assoc()['CantidadConsultas'];

                        echo "<div class='card mb-3 shadow text-center'>";
                        echo "<div class='card-body'>";
                        echo "<h3 class='card-title'>Paciente</h3>";
                        echo "<p><strong>Nombre:</strong> " . $profileData['Nombre'] . " <i class='fa-solid fa-user-pen float-end text-primary cursor-pointer' data-bs-toggle='modal' data-bs-target='#editModal' data-field='Nombre' data-value='" . $profileData['Nombre'] . "'></i></p>";
                        echo "<p><strong>Apellido:</strong> " . $profileData['Apellido'] . " <i class='fa-solid fa-user-pen float-end text-primary cursor-pointer' data-bs-toggle='modal' data-bs-target='#editModal' data-field='Apellido' data-value='" . $profileData['Apellido'] . "'></i></p>";
                        echo "<p><strong>DNI:</strong> " . $profileData['DNI'] . "</p>"; // No se muestra el ícono de edición para el DNI
                        echo "<p><strong>Correo:</strong> " . $user['mail'] . " <i class='fa-solid fa-user-pen float-end text-primary cursor-pointer' data-bs-toggle='modal' data-bs-target='#editModal' data-field='mail' data-value='" . $user['mail'] . "'></i></p>";
                        echo "<p><strong>Obra Social:</strong> " . $profileData['ObraSocial'] . " <i class='fa-solid fa-user-pen float-end text-primary cursor-pointer' data-bs-toggle='modal' data-bs-target='#editModal' data-field='ObraSocial'></i></p>";
                        echo "<p><strong>Cantidad de estudios realizados:</strong> " . $cantidadEstudios . "</p>";
                        echo "<p><strong>Cantidad de consultas realizadas:</strong> " . $cantidadConsultas . "</p>";
                        echo "</div></div>";
                    } elseif ($user['ID_Profesional']) {
                        // Perfil de doctor
                        $doctorId = $user['ID_Profesional'];
                        $query = "SELECT d.Nombre, d.Apellido, d.DNI, d.Matricula, e.Nombre AS Especialidad 
                              FROM doctores d 
                              JOIN especialidades e ON d.ID_Especialidad = e.ID_Especialidad 
                              WHERE d.ID_Profesional = '$doctorId'";
                        $result = $conexion->query($query);
                        $profileData = $result->fetch_assoc();

                        echo "<div class='card mb-3 shadow text-center'>";
                        echo "<div class='card-body'>";
                        echo "<h3 class='card-title'>Doctor</h3>";
                        echo "<p><strong>Nombre:</strong> " . $profileData['Nombre'] . " <i class='fa-solid fa-user-pen float-end text-primary cursor-pointer' data-bs-toggle='modal' data-bs-target='#editModal' data-field='Nombre' data-value='" . $profileData['Nombre'] . "'></i></p>";
                        echo "<p><strong>Apellido:</strong> " . $profileData['Apellido'] . " <i class='fa-solid fa-user-pen float-end text-primary cursor-pointer' data-bs-toggle='modal' data-bs-target='#editModal' data-field='Apellido' data-value='" . $profileData['Apellido'] . "'></i></p>";
                        echo "<p><strong>DNI:</strong> " . $profileData['DNI'] . "</p>"; // No se muestra el ícono de edición para el DNI
                        echo "<p><strong>Matrícula:</strong> " . $profileData['Matricula'] . "</p>"; // No se muestra el ícono de edición para la matrícula
                        echo "<p><strong>Especialidad:</strong> " . $profileData['Especialidad'] . " <i class='fa-solid fa-user-pen float-end text-primary cursor-pointer' data-bs-toggle='modal' data-bs-target='#editModal' data-field='Especialidad'></i></p>";
                        echo "<p><strong>Correo:</strong> " . $user['mail'] . " <i class='fa-solid fa-user-pen float-end text-primary cursor-pointer' data-bs-toggle='modal' data-bs-target='#editModal' data-field='mail' data-value='" . $user['mail'] . "'></i></p>";
                        echo "</div></div>";
                    }
                    ?>
                </div>
            </div>
        </section>
    </main>

    <!-- Modal para editar campo -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Campo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST" action="update_profile.php">
                    <div class="modal-body">
                        <input type="hidden" name="field" id="field">
                        <div class="mb-3" id="inputContainer">
                            <label for="fieldValue" class="form-label">Nuevo Valor</label>
                            <input type="text" class="form-control" id="fieldValue" name="fieldValue" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="footer bg-light text-center py-3">
        <div class="container">
            <p>© 2024 <strong>Historia Clínica Digital</strong> Todos los derechos reservados</p>
        </div>
    </footer>

    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        // Modal para cambiar entre input y lista desplegable
        var editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var field = button.getAttribute('data-field');
            var value = button.getAttribute('data-value');

            document.getElementById('field').value = field;
            var inputContainer = document.getElementById('inputContainer');
            inputContainer.innerHTML = ''; // Limpiar contenido previo

            if (field === 'ObraSocial' || field === 'Especialidad') {
                var options = field === 'ObraSocial' ?
                    <?php echo json_encode(array_column($obrasSociales, 'Nombre')); ?> :
                    <?php echo json_encode(array_column($especialidades, 'Nombre')); ?>;
                var select = document.createElement('select');
                select.name = 'fieldValue';
                select.id = 'fieldValue';
                select.className = 'form-control';

                options.forEach(function(optionText) {
                    var option = document.createElement('option');
                    option.value = optionText;
                    option.textContent = optionText;
                    select.appendChild(option);
                });
                inputContainer.appendChild(select);
            } else {
                var input = document.createElement('input');
                input.type = field === 'mail' ? 'email' : 'text';
                input.name = 'fieldValue';
                input.id = 'fieldValue';
                input.className = 'form-control';
                input.value = value;
                input.required = true;
                inputContainer.appendChild(input);
            }
        });
    </script>
</body>

</html>