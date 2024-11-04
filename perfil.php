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
          <li><a href="contact.php">Contacto</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <a class="cta-btn d-none d-sm-block" href="login.php">Cerrar Sesión</a>
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

              // obtener opciones de obras sociales
              $os_query = "SELECT Nombre FROM obras_sociales";
              $os_result = $conexion->query($os_query);
              $obrasSociales = $os_result->fetch_all(MYSQLI_ASSOC);

              echo "<div class='card mb-3 shadow text-center'>";
              echo "<div class='card-body'>";
              echo "<h3 class='card-title'>Paciente</h3>";
              echo "<p><strong>Nombre:</strong> " . $profileData['Nombre'] . " <i class='bi bi-pencil-square float-end text-primary' data-bs-toggle='modal' data-bs-target='#editModal' data-field='Nombre' data-value='" . $profileData['Nombre'] . "'></i></p>";
              echo "<p><strong>Apellido:</strong> " . $profileData['Apellido'] . " <i class='bi bi-pencil-square float-end text-primary' data-bs-toggle='modal' data-bs-target='#editModal' data-field='Apellido' data-value='" . $profileData['Apellido'] . "'></i></p>";
              echo "<p><strong>DNI:</strong> " . $profileData['DNI'] . "</p>";  // no se muestra el ícono de edición para el DNI
              echo "<p><strong>Correo:</strong> " . $user['mail'] . " <i class='bi bi-pencil-square float-end text-primary' data-bs-toggle='modal' data-bs-target='#editModal' data-field='mail' data-value='" . $user['mail'] . "'></i></p>";
              echo "<p><strong>Obra Social:</strong> " . $profileData['ObraSocial'] . " <i class='bi bi-pencil-square float-end text-primary' data-bs-toggle='modal' data-bs-target='#editModal' data-field='ObraSocial'></i></p>";
              echo "</div></div>";
          }
        ?>
      </div>
    </div>
  </section>
</main>

<!-- ventana editar campo -->
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
  // modal para cambiar entre input y lista desplegable
  var editModal = document.getElementById('editModal');
  editModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var field = button.getAttribute('data-field');
    var value = button.getAttribute('data-value');
    
    document.getElementById('field').value = field;

    var inputContainer = document.getElementById('inputContainer');
    if (field === 'ObraSocial') {
      // select con opciones de obras sociales
      var obrasSociales = <?php echo json_encode(array_column($obrasSociales, 'Nombre')); ?>;
      var select = document.createElement('select');
      select.name = 'fieldValue';
      select.id = 'fieldValue';
      select.className = 'form-control';
      
      obrasSociales.forEach(function(obraSocial) {
        var option = document.createElement('option');
        option.value = obraSocial;
        option.textContent = obraSocial;
        select.appendChild(option);
      });
      inputContainer.innerHTML = '';
      inputContainer.appendChild(select);
    } else {
      // input normal para otros campos
      var input = document.createElement('input');
      input.type = field === 'mail' ? 'email' : 'text';
      input.name = 'fieldValue';
      input.id = 'fieldValue';
      input.className = 'form-control';
      input.value = value;
      input.required = true;
      
      inputContainer.innerHTML = '';
      inputContainer.appendChild(input);
    }
  });
</script>
</body>
</html>
