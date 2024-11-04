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
</head>

<body class="index-page">

  <header id="header" class="header sticky-top">
    <div class="container d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center me-auto">
        <h1 class="sitename">Historia Clínica Digital</h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul class="nav">
          <li class="nav-item"><a href="index.php" class="nav-link">Inicio</a></li>
          <li class="nav-item"><a href="perfil.php" class="nav-link active">Perfil</a></li>
          <li class="nav-item"><a href="contact.php" class="nav-link">Contacto</a></li>
          <li class="nav-item"><a href="logout.php" class="nav-link">Cerrar Sesión</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
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
            include 'conexion.php';
            session_start();
            $userId = $_SESSION['ID_Cuenta'];
            
            $query = "SELECT ID_Paciente, ID_Profesional, mail FROM cuentas WHERE ID_Cuenta = '$userId'";
            $result = $conexion->query($query);
            $user = $result->fetch_assoc();

            if ($user['ID_Paciente']) {
                $patientId = $user['ID_Paciente'];
                $query = "SELECT p.Nombre, p.Apellido, p.DNI, o.Nombre AS ObraSocial 
                          FROM pacientes p 
                          JOIN obras_sociales o ON p.ID_OS = o.ID_OS 
                          WHERE p.ID_Paciente = '$patientId'";
                $result = $conexion->query($query);
                $profileData = $result->fetch_assoc();

                $query = "SELECT COUNT(*) AS ConsultasAnuales 
                          FROM consultas_medicas 
                          WHERE ID_Paciente = '$patientId' 
                          AND Fecha >= DATE_SUB(NOW(), INTERVAL 1 YEAR)";
                $consultasResult = $conexion->query($query);
                $consultasAnuales = $consultasResult->fetch_assoc()['ConsultasAnuales'];
                
                $query = "SELECT COUNT(*) AS EstudiosAnuales 
                          FROM estudios_medicos em 
                          JOIN consultas_medicas cm ON em.ID_Consulta = cm.ID_Consulta 
                          WHERE cm.ID_Paciente = '$patientId' 
                          AND cm.Fecha >= DATE_SUB(NOW(), INTERVAL 1 YEAR)";
                $estudiosResult = $conexion->query($query);
                $estudiosAnuales = $estudiosResult->fetch_assoc()['EstudiosAnuales'];

                echo "<div class='card mb-3 shadow text-center'>";
                echo "<div class='card-body'>";
                echo "<h3 class='card-title'>Paciente</h3>";
                echo "<p><strong>Nombre:</strong> " . $profileData['Nombre'] . " <i class='bi bi-pencil-square float-end text-primary' data-bs-toggle='modal' data-bs-target='#editModal' data-field='Nombre' data-value='" . $profileData['Nombre'] . "'></i></p>";
                echo "<p><strong>Apellido:</strong> " . $profileData['Apellido'] . " <i class='bi bi-pencil-square float-end text-primary' data-bs-toggle='modal' data-bs-target='#editModal' data-field='Apellido' data-value='" . $profileData['Apellido'] . "'></i></p>";
                echo "<p><strong>DNI:</strong> " . $profileData['DNI'] . " <i class='bi bi-pencil-square float-end text-primary' data-bs-toggle='modal' data-bs-target='#editModal' data-field='DNI' data-value='" . $profileData['DNI'] . "'></i></p>";
                echo "<p><strong>Correo:</strong> " . $user['mail'] . " <i class='bi bi-pencil-square float-end text-primary' data-bs-toggle='modal' data-bs-target='#editModal' data-field='mail' data-value='" . $user['mail'] . "'></i></p>";
                echo "<p><strong>Obra Social:</strong> " . $profileData['ObraSocial'] . "</p>";
                echo "<p><strong>Cantidad de consultas último año:</strong> $consultasAnuales</p>";
                echo "<p><strong>Cantidad de estudios último año:</strong> $estudiosAnuales</p>";
                echo "</div></div>";
                
            }
          ?>
        </div>
      </div>
    </section>
  </main>

  <!-- modal para editar campo -->
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
            <div class="mb-3">
              <label for="fieldValue" class="form-label">Nuevo Valor</label>
              <input type="text" class="form-control" id="fieldValue" name="fieldValue">
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
    // vista modal campo actual
    var editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      var field = button.getAttribute('data-field');
      var value = button.getAttribute('data-value');
      
      document.getElementById('field').value = field;
      document.getElementById('fieldValue').value = value;
    });
  </script>
</body>

</html>
