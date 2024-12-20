<?php
include 'conexion.php';

// Detecta si es una solicitud AJAX para cargar datos de un registro específico
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'fetchData') {
    $id = intval($_POST['id']);
    
    // Consulta base para la cuenta
    $stmt = $conexion->prepare("SELECT * FROM cuentas WHERE ID_Cuenta = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    // Consultar datos adicionales dependiendo del tipo de cuenta
    if ($data['ID_Tipo'] == 1) { // Paciente
        $stmt = $conexion->prepare("SELECT Nombre, Apellido, DNI, ID_OS FROM pacientes WHERE ID_Paciente = ?");
        $stmt->bind_param("i", $data['ID_Paciente']);
        $stmt->execute();
        $result = $stmt->get_result();
        $pacienteData = $result->fetch_assoc();
        $data = array_merge($data, $pacienteData);
    } elseif ($data['ID_Tipo'] == 2) { // Profesional
        $stmt = $conexion->prepare("SELECT Nombre, Apellido, DNI, Matricula, ID_Especialidad FROM doctores WHERE ID_Profesional = ?");
        $stmt->bind_param("i", $data['ID_Profesional']);
        $stmt->execute();
        $result = $stmt->get_result();
        $doctorData = $result->fetch_assoc();
        $data = array_merge($data, $doctorData);
    }

    // Enviar los datos como JSON y detener la ejecución
    header('Content-Type: application/json');
    echo json_encode($data);
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Historia Clínica Digital</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="index-page">

  <header id="header" class="header sticky-top">
    <div class="topbar d-flex align-items-center">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
          <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:info@historiaclinica.com">info@historiaclinica.com</a></i>
          <i class="bi bi-phone d-flex align-items-center ms-4"><span>+0800 555 2368</span></i>
        </div>
      </div>
    </div><!-- End Top Bar -->

    <div class="branding d-flex align-items-center">
      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="index.php" class="logo d-flex align-items-center me-auto">
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <!-- <img src="assets/img/logo.png" alt=""> -->
          <h1 class="sitename">Historia Clínica Digital</h1>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="index.php">Inicio</a></li>
            <!-- <li><a href="perfil.php">Mi Perfil</a></li>
            <li><a href="consulta.php">Consultas</a></li> -->
            <li class="dropdown"><a href="crud.php" class="active"><span>Administrador</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>                
                <li><a href="crud_especialidades.php">Especialidades</a></li>
                <li><a href="crud_obras_sociales.php">Obras Sociales</a></li>
                <li><a href="crud_cuentas.php">Cuentas</a></li>
              </ul>
            </li>
            <li><a href="contact.php">Contacto</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <a class="cta-btn d-none d-sm-block" href="logout.php">Cerrar Sesión</a>
      </div>
    </div>
  </header>

  <main class="main">
    <section id="contact" class="contact section container mt-4">
      <div class="container section-title">
        <h2>ABM Cuentas</h2>
      </div>

      <!-- Sección de acciones (Botón + Formulario de búsqueda) -->
<div class="row mb-4 align-items-end">
  <!-- Botón "Nueva Cuenta" -->
  <div class="col-lg-2 col-md-3 col-12 mb-2 mb-md-0">
    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#newAccountModal">
      Nueva Cuenta
    </button>
  </div>

  <!-- Formulario de búsqueda -->
  <form method="GET" action="crud_cuentas.php" class="col-lg-10 col-md-9 col-12">
    <div class="row gx-2">
      <div class="col-lg-2 col-md-3 col-6 mb-2 mb-md-0">
        <input type="text" class="form-control" name="id_cuenta" placeholder="🔍 ID Cuenta" value="<?php echo isset($_GET['id_cuenta']) ? $_GET['id_cuenta'] : ''; ?>">
      </div>
      <div class="col-lg-3 col-md-3 col-6 mb-2 mb-md-0">
        <input type="text" class="form-control" name="buscador" placeholder="🔍 Nombre - Mail" value="<?php echo isset($_GET['buscador']) ? $_GET['buscador'] : ''; ?>">
      </div>
      <div class="col-lg-2 col-md-3 col-6 mb-2 mb-md-0">
        <input type="text" class="form-control" name="dni" placeholder="🔍 DNI" value="<?php echo isset($_GET['dni']) ? $_GET['dni'] : ''; ?>">
      </div>
      <div class="col-lg-3 col-md-3 col-6 mb-2 mb-md-0">
        <select class="form-select" name="tipo_cuenta">
          <option value="">Tipo de Cuenta</option>
          <option value="1" <?php if (isset($_GET['tipo_cuenta']) && $_GET['tipo_cuenta'] == '1') echo 'selected'; ?>>Paciente</option>
          <option value="2" <?php if (isset($_GET['tipo_cuenta']) && $_GET['tipo_cuenta'] == '2') echo 'selected'; ?>>Profesional</option>
          <option value="3" <?php if (isset($_GET['tipo_cuenta']) && $_GET['tipo_cuenta'] == '3') echo 'selected'; ?>>Administrador</option>
        </select>
      </div>
      <div class="col-lg-2 col-md-12 col-12 mt-2 mt-lg-0">
        <button type="submit" class="btn btn-primary w-100" name="buscar" value="ok">Buscar</button>
      </div>
    </div>
  </form>
</div>


      <!-- Tabla de resultados -->
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead class="bg-info text-white">
            <tr>
              <th scope="col">ID Cuenta</th>
              <th scope="col">Tipo</th>
              <th scope="col">Mail</th>
              <th scope="col">Nombre</th>
              <th scope="col">Apellido</th>
              <th scope="col">DNI</th>
              <th scope="col">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php
              include "conexion.php";
              $id_cuenta = isset($_GET['id_cuenta']) ? $_GET['id_cuenta'] : '';
              $buscador = isset($_GET['buscador']) ? $_GET['buscador'] : '';
              $dni = isset($_GET['dni']) ? $_GET['dni'] : '';
              $tipo_cuenta = isset($_GET['tipo_cuenta']) ? $_GET['tipo_cuenta'] : '';

              $query = "SELECT 
                          cuentas.ID_Cuenta, 
                          cuentas.ID_Tipo, 
                          tipos_cuentas.Descripcion AS Tipo, 
                          cuentas.Mail,
                          IFNULL(pacientes.Nombre, doctores.Nombre) AS Nombre,
                          IFNULL(pacientes.Apellido, doctores.Apellido) AS Apellido,
                          IFNULL(pacientes.DNI, doctores.DNI) AS DNI
                        FROM cuentas
                        LEFT JOIN tipos_cuentas ON cuentas.ID_Tipo = tipos_cuentas.ID_Tipo
                        LEFT JOIN pacientes ON cuentas.ID_Paciente = pacientes.ID_Paciente
                        LEFT JOIN doctores ON cuentas.ID_Profesional = doctores.ID_Profesional
                        WHERE 1=1";

              $params = [];
              $types = "";

              // Filtro por ID Cuenta
              if (!empty($id_cuenta)) {
                  $query .= " AND cuentas.ID_Cuenta LIKE ?";
                  $params[] = "%" . $id_cuenta . "%";
                  $types .= "s";
              }

              // Filtro por buscador general (Nombre, Apellido, Mail)
              if (!empty($buscador)) {
                  $query .= " AND (pacientes.Nombre LIKE ? OR pacientes.Apellido LIKE ? OR doctores.Nombre LIKE ? OR doctores.Apellido LIKE ? OR cuentas.Mail LIKE ?)";
                  $likeBuscador = "%" . $buscador . "%";
                  $params = array_merge($params, array_fill(0, 5, $likeBuscador));
                  $types .= str_repeat("s", 5);
              }

              // Filtro por DNI
              if (!empty($dni)) {
                  $query .= " AND (pacientes.DNI LIKE ? OR doctores.DNI LIKE ?)";
                  $params[] = "%" . $dni . "%";
                  $params[] = "%" . $dni . "%";
                  $types .= "ss";
              }

              // Filtro por Tipo de Cuenta
              if (!empty($tipo_cuenta)) {
                  $query .= " AND cuentas.ID_Tipo = ?";
                  $params[] = $tipo_cuenta;
                  $types .= "i";
              }

              if (!empty($params)) {
                  $stmt = $conexion->prepare($query);
                  $stmt->bind_param($types, ...$params);
                  $stmt->execute();
                  $result = $stmt->get_result();
              } else {
                  $result = $conexion->query($query);
              }


            while ($datos = $result->fetch_object()) { ?>
              <tr>
                <td><?= $datos->ID_Cuenta ?></td>
                <td><?= $datos->Tipo ?></td>
                <td><?= $datos->Mail ?></td>
                <td><?= $datos->Nombre ?></td> <!-- Mostrar Nombre -->
                <td><?= $datos->Apellido ?></td> <!-- Mostrar Apellido -->
                <td><?= $datos->DNI ?></td> <!-- Mostrar DNI -->
                <td>
                  <a href="#" onclick="editRecord(<?= $datos->ID_Cuenta ?>);" title="Editar" class="text-primary me-3">
                    <i class="fa-solid fa-user-pen"></i>
                  </a>
                  <a href="#" onclick="confirmDelete(<?= $datos->ID_Cuenta ?>);" title="Eliminar" class="text-danger">
                    <i class="fa-solid fa-trash"></i>
                  </a>
                </td>
              </tr>
            <?php }
            
            ?>
          </tbody>
        </table>
      </div>
    </section>
  </main>

  <!-- Modales -->
  <!-- Modal para editar -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="crud_cuentas.php">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Editar Cuenta</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Campo oculto para ID_Cuenta -->
          <input type="hidden" name="id_cuenta" id="editIdCuenta">
          
          <!-- Campos generales -->
          <div class="mb-3">
            <label for="editTipo" class="form-label">Tipo</label>
            <select class="form-select" name="id_tipo" id="editTipo" onchange="toggleEditFields()" required>
              <option value="1">Paciente</option>
              <option value="2">Profesional</option>
              <option value="3">Administrador</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="editMail" class="form-label">Mail</label>
            <input type="email" class="form-control" name="mail" id="editMail" required>
          </div>

          <!-- Campos para Paciente -->
          <div id="editPacienteFields" style="display: none;">
            <div class="mb-3">
                <label for="editNombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre_paciente" id="editNombre">
            </div>
            <div class="mb-3">
                <label for="editApellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" name="apellido_paciente" id="editApellido">
            </div>
            <div class="mb-3">
                <label for="editDni" class="form-label">DNI</label>
                <input type="text" class="form-control" name="dni_paciente" id="editDni">
            </div>
            <div class="mb-3">
                <label for="editObraSocial" class="form-label">Obra Social</label>

              <select class="form-select" name="id_os" id="editObraSocial">
                <?php
                  // Consulta para obtener las obras sociales
                  $result = $conexion->query("SELECT ID_OS, Nombre FROM obras_sociales");
                  while ($row = $result->fetch_assoc()) {
                    $id_os = htmlspecialchars($row['ID_OS'], ENT_QUOTES, 'UTF-8');
                    $nombre_os = htmlspecialchars($row['Nombre'], ENT_QUOTES, 'UTF-8');
                    echo "<option value='$id_os'>$nombre_os</option>";
                  }
                ?>
              </select>

            </div>
          </div>

          <!-- Campos para Profesional -->
          <div id="editProfesionalFields" style="display: none;">
              <div class="mb-3">
                  <label for="editNombreProfesional" class="form-label">Nombre</label>
                  <input type="text" class="form-control" name="nombre_profesional" id="editNombreProfesional">
              </div>
              <div class="mb-3">
                  <label for="editApellidoProfesional" class="form-label">Apellido</label>
                  <input type="text" class="form-control" name="apellido_profesional" id="editApellidoProfesional">
              </div>
              <div class="mb-3">
                  <label for="editDniProfesional" class="form-label">DNI</label>
                  <input type="text" class="form-control" name="dni_profesional" id="editDniProfesional">
              </div>
              <div class="mb-3">
                  <label for="editMatricula" class="form-label">Matrícula</label>
                  <input type="text" class="form-control" name="matricula" id="editMatricula">
              </div>
              <div class="mb-3">
                <label for="editEspecialidad" class="form-label">Especialidad</label>
                <select class="form-select" name="id_especialidad" id="editEspecialidad">
                    <?php
                    // Consulta para obtener las especialidades
                    $result = $conexion->query("SELECT ID_Especialidad, Nombre FROM especialidades");
                    while ($row = $result->fetch_assoc()) {
                        $id_especialidad = htmlspecialchars($row['ID_Especialidad'], ENT_QUOTES, 'UTF-8');
                        $nombre_especialidad = htmlspecialchars($row['Nombre'], ENT_QUOTES, 'UTF-8');
                        echo "<option value='$id_especialidad'>$nombre_especialidad</option>";
                    }
                    ?>
                </select>
              </div>

          </div>

          <!-- Campos para Administrador (si tienes campos adicionales, agrégalos aquí) -->
          <!-- ... -->

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" name="actualizar">Guardar cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>



  <!-- Modal para agregar -->
<!-- Modal para agregar -->
<div class="modal fade" id="newAccountModal" tabindex="-1" aria-labelledby="newAccountModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="crud_cuentas.php">

        <div class="modal-header">
          <h5 class="modal-title" id="newAccountModalLabel">Agregar Nueva Cuenta</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Campo Tipo -->
          <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <select class="form-select" name="id_tipo" id="tipo" onchange="toggleFields()" required>
              <option value="">Seleccione un tipo</option>
              <option value="1">Paciente</option>
              <option value="2">Profesional</option>
              <option value="3">Administrador</option>
            </select>
          </div>
          
          <!-- Campos para Paciente y Profesional -->
          <div id="pacienteProfesionalFields" style="display: none;">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" name="nombre" id="nombre">
            </div>
            <div class="mb-3">
              <label for="apellido" class="form-label">Apellido</label>
              <input type="text" class="form-control" name="apellido" id="apellido">
            </div>
            <div class="mb-3">
              <label for="dni" class="form-label">DNI</label>
              <input type="text" class="form-control" name="dni" id="dni">
            </div>
          </div>


          <div id="passwordField" style="display: none;">
            <div class="mb-3">
              <label for="password_pp" class="form-label">Contraseña</label>
              <input type="password" class="form-control" name="password" id="password_pp">
            </div>
          </div>


            <!-- Campos solo para Paciente -->
            <div id="pacienteOSField" style="display: none;">
            <div class="mb-3">
              <label for="id_os" class="form-label">Obra Social</label>
              <select class="form-select" name="id_os" id="id_os">
                <option value="">Seleccione una obra social</option>
                <?php
                  // Consulta para obtener las obras sociales activas
                  $result = $conexion->query("SELECT ID_OS, Nombre FROM obras_sociales");
                  while ($row = $result->fetch_assoc()) {
                    $id_os = htmlspecialchars($row['ID_OS'], ENT_QUOTES, 'UTF-8');
                    $nombre_os = htmlspecialchars($row['Nombre'], ENT_QUOTES, 'UTF-8');
                    echo "<option value='" . $id_os . "'>" . $nombre_os . "</option>";
                  }
                ?>

              </select>
            </div>
          </div>
          
          <!-- Campos solo para Profesional -->

          <div id="profesionalFields" style="display: none;">
            <div class="mb-3">
              <label for="matricula" class="form-label">Matrícula</label>
              <input type="text" class="form-control" name="matricula" id="matricula">
            </div>
          </div>


          <div id="especialidadField" style="display: none;">
  <div class="mb-3">
    <label for="id_especialidad" class="form-label">Especialidad</label>
    <select class="form-select" name="id_especialidad" id="id_especialidad">
      <option value="">Seleccione una especialidad</option>
      <?php
        // Consulta para obtener las especialidades
        $result = $conexion->query("SELECT ID_Especialidad, Nombre FROM especialidades");
        while ($row = $result->fetch_assoc()) {
            $id_especialidad = htmlspecialchars($row['ID_Especialidad'], ENT_QUOTES, 'UTF-8');
            $nombre_especialidad = htmlspecialchars($row['Nombre'], ENT_QUOTES, 'UTF-8');
            echo "<option value='$id_especialidad'>$nombre_especialidad</option>";
        }
      ?>
    </select>
  </div>
</div>

          
          <!-- Campos para Administrador -->
          <div id="adminFields" style="display: none;">
            <div class="mb-3">
              <label for="password_admin" class="form-label">Contraseña</label>
              <input type="password" class="form-control" name="password" id="password_admin">
            </div>
          </div>
          
          <!-- Campo de mail -->
          <div class="mb-3">
            <label for="mail" class="form-label">Mail</label>
            <input type="email" class="form-control" name="mail" required>
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" name="guardar_cuenta">Guardar</button>
        </div>
        
      </form>
    </div>
  </div>
</div>

<!-- Modal para mostrar mensajes de error y confirmación -->
<div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="alertModalLabel">Mensaje</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="alertMessage">
        <!-- El mensaje se mostrará aquí -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal de confirmación de eliminación -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de que deseas eliminar esta cuenta?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteButton">Eliminar</button>
      </div>
    </div>
  </div>
</div>

  <footer class="footer light-background">
    <div class="container copyright text-center">
      <p>© 2024 <strong class="px-1 sitename">Historia Clinica Digital</strong> <span>Todos los derechos reservados</span></p>
    </div>
  </footer>

  <!-- Scripts -->

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script>
function editRecord(id) {
    // Fetch para cargar datos en el modal
    fetch('crud_cuentas.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'action=fetchData&id=' + id
    })
    .then(response => response.json())
    .then(data => {
        // Llenar campos del modal con datos de la cuenta
        document.getElementById('editIdCuenta').value = data.ID_Cuenta;
        document.getElementById('editTipo').value = data.ID_Tipo;
        document.getElementById('editMail').value = data.Mail;

        // Mostrar los campos según el tipo
        toggleEditFields();

        // Llenar campos adicionales según el tipo
        if (data.ID_Tipo == 1) { // Paciente
            document.getElementById('editNombre').value = data.Nombre;
            document.getElementById('editApellido').value = data.Apellido;
            document.getElementById('editDni').value = data.DNI;
            document.getElementById('editObraSocial').value = data.ID_OS;
        } else if (data.ID_Tipo == 2) { // Profesional
            document.getElementById('editNombreProfesional').value = data.Nombre;
            document.getElementById('editApellidoProfesional').value = data.Apellido;
            document.getElementById('editDniProfesional').value = data.DNI;
            document.getElementById('editMatricula').value = data.Matricula;
            document.getElementById('editEspecialidad').value = data.ID_Especialidad;
        }

        // Mostrar el modal de edición
        new bootstrap.Modal(document.getElementById('editModal')).show();
    });
}



function toggleEditFields() {
    const tipo = document.getElementById('editTipo').value;
    const pacienteFields = document.querySelectorAll('#editPacienteFields input, #editPacienteFields select');
    const profesionalFields = document.querySelectorAll('#editProfesionalFields input, #editProfesionalFields select');

    if (tipo == 1) { // Paciente
        document.getElementById('editPacienteFields').style.display = 'block';
        document.getElementById('editProfesionalFields').style.display = 'none';

        pacienteFields.forEach(el => el.disabled = false);
        profesionalFields.forEach(el => el.disabled = true);
    } else if (tipo == 2) { // Profesional
        document.getElementById('editPacienteFields').style.display = 'none';
        document.getElementById('editProfesionalFields').style.display = 'block';

        pacienteFields.forEach(el => el.disabled = true);
        profesionalFields.forEach(el => el.disabled = false);
    } else { // Administrador
        document.getElementById('editPacienteFields').style.display = 'none';
        document.getElementById('editProfesionalFields').style.display = 'none';

        pacienteFields.forEach(el => el.disabled = true);
        profesionalFields.forEach(el => el.disabled = true);
    }
}


  </script>

<script>
  function validateTipo() {
    const idTipoInput = document.getElementById("id_tipo");
    const idTipoError = document.getElementById("id_tipo_error");
    const idTipoValue = parseInt(idTipoInput.value, 10);

    if (![1, 2, 3].includes(idTipoValue)) {
      idTipoError.style.display = "block"; // Muestra el mensaje de error
      return false; // Evita el envío del formulario
    } else {
      idTipoError.style.display = "none"; // Oculta el mensaje de error si la validación pasa
      return true; // Permite el envío del formulario
    }
  }
</script>

<script>
function toggleFields() {
    const tipoSelect = document.getElementById("tipo");
    const pacienteProfesionalFields = document.getElementById("pacienteProfesionalFields");
    const adminFields = document.getElementById("adminFields");
    const pacienteOSField = document.getElementById("pacienteOSField");
    const especialidadField = document.getElementById("especialidadField");
    const profesionalFields = document.getElementById("profesionalFields");
    const passwordField = document.getElementById("passwordField");

    // Campos de contraseña
    const passwordPP = document.getElementById("password_pp");
    const passwordAdmin = document.getElementById("password_admin");

    // Restablecer la visibilidad
    pacienteProfesionalFields.style.display = "none";
    adminFields.style.display = "none";
    pacienteOSField.style.display = "none";
    especialidadField.style.display = "none";
    profesionalFields.style.display = "none";
    passwordField.style.display = "none";

    // Remover 'required' de ambos campos de contraseña
    passwordPP.removeAttribute("required");
    passwordAdmin.removeAttribute("required");

    if (tipoSelect.value === "1") { // Paciente
        pacienteProfesionalFields.style.display = "block";
        pacienteOSField.style.display = "block";
        passwordField.style.display = "block";
        passwordPP.setAttribute("required", "required"); // Añadir 'required' al campo de Paciente/Profesional
    } else if (tipoSelect.value === "2") { // Profesional
        pacienteProfesionalFields.style.display = "block";
        especialidadField.style.display = "block";
        profesionalFields.style.display = "block";
        passwordField.style.display = "block";
        passwordPP.setAttribute("required", "required"); // Añadir 'required' al campo de Paciente/Profesional
    } else if (tipoSelect.value === "3") { // Administrador
        adminFields.style.display = "block";
        passwordAdmin.setAttribute("required", "required"); // Añadir 'required' al campo de Administrador
    }
}
</script>

<script>
function showAlert(message) {
  document.getElementById("alertMessage").textContent = message;
  var alertModal = new bootstrap.Modal(document.getElementById("alertModal"));
  alertModal.show();
}

let deleteId = null; // Variable para almacenar el ID a eliminar

function confirmDelete(id) {
  deleteId = id; // Guardamos el ID de la cuenta a eliminar
  var confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
  confirmDeleteModal.show();
}

document.getElementById('confirmDeleteButton').addEventListener('click', function() {
  // Redirigir a la URL de eliminación con el ID correspondiente
  window.location.href = '?delete=' + deleteId;
});
</script>

  <!--Backend -->

  <?php

  include "conexion.php";

// Manejo de eliminación
if (isset($_GET['delete'])) {
  $id_cuenta = intval($_GET['delete']);

  // Obtener información de la cuenta
  $stmt = $conexion->prepare("SELECT ID_Tipo, ID_Paciente, ID_Profesional FROM cuentas WHERE ID_Cuenta = ?");
  $stmt->bind_param("i", $id_cuenta);
  $stmt->execute();
  $result = $stmt->get_result();
  $cuenta = $result->fetch_assoc();
  $stmt->close();

  if ($cuenta) {
      $id_tipo = $cuenta['ID_Tipo'];

      // Iniciar transacción
      $conexion->begin_transaction();

      try {
          // **Primero, eliminar la cuenta**
          $stmt = $conexion->prepare("DELETE FROM cuentas WHERE ID_Cuenta = ?");
          $stmt->bind_param("i", $id_cuenta);
          $stmt->execute();
          $stmt->close();

          // **Luego, eliminar registros relacionados**
          if ($id_tipo == 1) { // Paciente
              $id_paciente = $cuenta['ID_Paciente'];

              // Verificar si $id_paciente no es nulo
              if (!empty($id_paciente)) {
                  // Eliminar paciente
                  $stmt = $conexion->prepare("DELETE FROM pacientes WHERE ID_Paciente = ?");
                  $stmt->bind_param("i", $id_paciente);
                  $stmt->execute();
                  $stmt->close();
              }
          } elseif ($id_tipo == 2) { // Profesional
              $id_profesional = $cuenta['ID_Profesional'];

              // Verificar si $id_profesional no es nulo
              if (!empty($id_profesional)) {
                  // Eliminar profesional
                  $stmt = $conexion->prepare("DELETE FROM doctores WHERE ID_Profesional = ?");
                  $stmt->bind_param("i", $id_profesional);
                  $stmt->execute();
                  $stmt->close();
              }
          }

          // Confirmar transacción
          $conexion->commit();

          echo "<script>showAlert('Cuenta eliminada exitosamente');</script>";
          echo "<script>setTimeout(function(){ window.location.href='crud_cuentas.php'; }, 2000);</script>";
      } catch (mysqli_sql_exception $e) {
          // Revertir transacción
          $conexion->rollback();

          // Verificar el código de error
          if ($e->getCode() == 1451) {
              // Violación de restricción de clave foránea
              echo "<script>showAlert('No se puede eliminar la cuenta porque tiene datos relacionados.');</script>";
              echo "<script>setTimeout(function(){ window.location.href='crud_cuentas.php'; }, 2000);</script>";
          } else {
              // Otros errores
              echo "<script>showAlert('Error al eliminar la cuenta: " . $e->getMessage() . "');</script>";
              echo "<script>setTimeout(function(){ window.location.href='crud_cuentas.php'; }, 2000);</script>";
          }
      }
  } else {
      echo "<script>showAlert('Cuenta no encontrada');</script>";
      echo "<script>setTimeout(function(){ window.location.href='crud_cuentas.php'; }, 2000);</script>";
  }
}


// Actualización de datos
if (isset($_POST['actualizar'])) {
  $id_cuenta = intval($_POST['id_cuenta']);
  $id_tipo = $_POST['id_tipo'];
  $mail = $_POST['mail'];

  // Actualizar la tabla 'cuentas'
  $stmt = $conexion->prepare("UPDATE cuentas SET ID_Tipo = ?, Mail = ? WHERE ID_Cuenta = ?");
  $stmt->bind_param("isi", $id_tipo, $mail, $id_cuenta);

  if ($stmt->execute()) {
      // Actualizar tablas adicionales según el tipo
      if ($id_tipo == 1) { // Paciente
          $nombre = $_POST['nombre_paciente'];
          $apellido = $_POST['apellido_paciente'];
          $dni = $_POST['dni_paciente'];
          $id_os = intval($_POST['id_os']);

          // Obtener ID_Paciente asociado
          $stmt_paciente = $conexion->prepare("SELECT ID_Paciente FROM cuentas WHERE ID_Cuenta = ?");
          $stmt_paciente->bind_param("i", $id_cuenta);
          $stmt_paciente->execute();
          $result_paciente = $stmt_paciente->get_result();
          if ($row = $result_paciente->fetch_assoc()) {
              $id_paciente = $row['ID_Paciente'];
              $stmt_update_paciente = $conexion->prepare("UPDATE pacientes SET Nombre = ?, Apellido = ?, DNI = ?, ID_OS = ? WHERE ID_Paciente = ?");
              $stmt_update_paciente->bind_param("sssii", $nombre, $apellido, $dni, $id_os, $id_paciente);
              $stmt_update_paciente->execute();
              $stmt_update_paciente->close();
          }
          $stmt_paciente->close();
      } elseif ($id_tipo == 2) { // Profesional
          $nombre = $_POST['nombre_profesional'];
          $apellido = $_POST['apellido_profesional'];
          $dni = $_POST['dni_profesional'];
          $matricula = $_POST['matricula'];
          $id_especialidad = intval($_POST['id_especialidad']);

          // Verificar que $id_especialidad tiene un valor válido
          if (empty($id_especialidad)) {
              echo "<script>showAlert('Error: Debe seleccionar una especialidad.');</script>";
              exit;
          }

          // Obtener ID_Profesional asociado
          $stmt_profesional = $conexion->prepare("SELECT ID_Profesional FROM cuentas WHERE ID_Cuenta = ?");
          $stmt_profesional->bind_param("i", $id_cuenta);
          $stmt_profesional->execute();
          $result_profesional = $stmt_profesional->get_result();
          if ($row = $result_profesional->fetch_assoc()) {
              $id_profesional = $row['ID_Profesional'];
              $stmt_update_profesional = $conexion->prepare("UPDATE doctores SET Nombre = ?, Apellido = ?, DNI = ?, Matricula = ?, ID_Especialidad = ? WHERE ID_Profesional = ?");
              $stmt_update_profesional->bind_param("sssiii", $nombre, $apellido, $dni, $matricula, $id_especialidad, $id_profesional);
              $stmt_update_profesional->execute();
              $stmt_update_profesional->close();
          }
          $stmt_profesional->close();
      }
      echo "<script>showAlert('Cuenta actualizada exitosamente');</script>";
      echo "<script>setTimeout(function(){ window.location.href='crud_cuentas.php'; }, 2000);</script>";
  } else {
      echo "<script>showAlert('Error al actualizar la cuenta');</script>";
  }
  $stmt->close();
}

  // Inserción de nueva cuenta

  if (isset($_POST['guardar_cuenta'])) {
    $id_tipo = intval($_POST['id_tipo']);
    $mail = $_POST['mail'];
    $password = sha1($_POST['password']); // Encriptación con SHA1
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $dni = $_POST['dni'];

    // Verificación de duplicidad del DNI para pacientes y profesionales
    if ($id_tipo === 1) { 
        $stmt_check_dni = $conexion->prepare("SELECT ID_Paciente FROM pacientes WHERE DNI = ?");
        $stmt_check_dni->bind_param("s", $dni);
    } elseif ($id_tipo === 2) { 
        $stmt_check_dni = $conexion->prepare("SELECT ID_Profesional FROM doctores WHERE DNI = ?");
        $stmt_check_dni->bind_param("s", $dni);
    }

    if (isset($stmt_check_dni)) { // Si hay chequeo de duplicidad (para pacientes/profesionales)
        $stmt_check_dni->execute();
        $stmt_check_dni->store_result();
        if ($stmt_check_dni->num_rows > 0) {
            echo "<script>showAlert('Error: El DNI ya está registrado.');</script>";
            exit;
        }
        $stmt_check_dni->close();
    }

    // Proceso de inserción según el tipo
    if ($id_tipo === 1) { // Paciente
        // Inserción en tabla pacientes y luego en cuentas
        $id_os = intval($_POST['id_os']);
        $stmt = $conexion->prepare("INSERT INTO pacientes (Nombre, Apellido, DNI, ID_OS) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $nombre, $apellido, $dni, $id_os);
        if ($stmt->execute()) {
            $id_paciente = $conexion->insert_id;
            $stmt_cuenta = $conexion->prepare("INSERT INTO cuentas (ID_Tipo, Mail, Password, ID_Paciente) VALUES (?, ?, ?, ?)");
            $stmt_cuenta->bind_param("issi", $id_tipo, $mail, $password, $id_paciente);
            $stmt_cuenta->execute();
            echo "<script>showAlert('Cuenta de paciente agregada exitosamente');</script>";
            echo "<script>setTimeout(function(){ window.location.href='crud_cuentas.php'; }, 2000);</script>";
        }

    } elseif ($id_tipo === 2) { // Profesional
        // Inserción en tabla doctores y luego en cuentas
        $matricula = $_POST['matricula'];
        $id_especialidad = intval($_POST['id_especialidad']);
        $stmt = $conexion->prepare("INSERT INTO doctores (Nombre, Apellido, DNI, Matricula, ID_Especialidad) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $nombre, $apellido, $dni, $matricula, $id_especialidad);
        if ($stmt->execute()) {
            $id_profesional = $conexion->insert_id;
            $stmt_cuenta = $conexion->prepare("INSERT INTO cuentas (ID_Tipo, Mail, Password, ID_Profesional) VALUES (?, ?, ?, ?)");
            $stmt_cuenta->bind_param("issi", $id_tipo, $mail, $password, $id_profesional);
            $stmt_cuenta->execute();
            echo "<script>showAlert('Cuenta de profesional agregada exitosamente');</script>";
            echo "<script>setTimeout(function(){ window.location.href='crud_cuentas.php'; }, 2000);</script>";
        }

    } elseif ($id_tipo === 3) { // Administrador
        // Inserción directamente en cuentas sin tabla extra
        $stmt_cuenta = $conexion->prepare("INSERT INTO cuentas (ID_Tipo, Mail, Password) VALUES (?, ?, ?)");
        $stmt_cuenta->bind_param("iss", $id_tipo, $mail, $password);
        if ($stmt_cuenta->execute()) {
            echo "<script>showAlert('Cuenta de administrador agregada exitosamente');</script>";
            echo "<script>setTimeout(function(){ window.location.href='crud_cuentas.php'; }, 2000);</script>";
        } else {
            echo "<script>showAlert('Error al insertar la cuenta de administrador');</script>";
        }
    }
}

?>

</body>
</html>