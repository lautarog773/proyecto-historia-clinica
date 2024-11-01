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
            <li><a href="perfil.php">Mi Perfil</a></li>
            <li><a href="consulta.php">Consultas</a></li>
            <li class="dropdown"><a href="crud.php" class="active"><span>CRUD</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
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

        <a class="cta-btn d-none d-sm-block" href="login.php">Cerrar Sesión</a>
      </div>
    </div>
  </header>

  <main class="main">
    <section id="contact" class="contact section container mt-4">
      <div class="container section-title">
        <h2>CRUD Cuentas</h2>
      </div>

      <!-- Sección de acciones (Botón + Formulario de búsqueda) -->
      <div class="row mb-4 align-items-center">
        <!-- Botón "Nueva Cuenta" -->
        <div class="col-md-3 col-12 mb-2 mb-md-0">
          <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#newAccountModal">
            Nueva Cuenta
          </button>
        </div>

        <!-- Formulario de búsqueda -->
        <form method="GET" action="crud_cuentas.php" class="col-md-9 col-12 row gx-2">
          <div class="col-md-4 col-12 mb-2 mb-md-0">
            <input type="text" class="form-control" name="id_cuenta" placeholder="ID Cuenta" value="<?php echo isset($_GET['id_cuenta']) ? $_GET['id_cuenta'] : ''; ?>">
          </div>
          <div class="col-md-4 col-12 mb-2 mb-md-0">
            <input type="text" class="form-control" name="mail" placeholder="Mail" value="<?php echo isset($_GET['mail']) ? $_GET['mail'] : ''; ?>">
          </div>
          <div class="col-md-4 col-12">
            <button type="submit" class="btn btn-primary w-100" name="buscar" value="ok">Buscar</button>
          </div>
        </form>
      </div>

      <!-- Tabla de resultados -->
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead class="bg-info text-white">
            <tr>
              <th scope="col">ID Cuenta</th>
              <th scope="col">ID Tipo</th>
              <th scope="col">Mail</th>
              <th scope="col">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include "conexion.php";
            $id_cuenta = isset($_GET['id_cuenta']) ? $_GET['id_cuenta'] : '';
            $mail = isset($_GET['mail']) ? $_GET['mail'] : '';
            $query = "SELECT * FROM cuentas WHERE 1=1";
            $params = [];
            $types = "";

            if (!empty($id_cuenta)) {
                $query .= " AND ID_Cuenta LIKE ?";
                $params[] = "%" . $id_cuenta . "%";
                $types .= "s";
            }
            if (!empty($mail)) {
                $query .= " AND Mail LIKE ?";
                $params[] = "%" . $mail . "%";
                $types .= "s";
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
                <td><?= $datos->ID_Tipo ?></td>
                <td><?= $datos->Mail ?></td>
                <td>
                  <a href="#" onclick="editRecord(<?= $datos->ID_Cuenta ?>, <?= $datos->ID_Tipo ?>, '<?= $datos->Mail ?>')" title="Editar" class="text-primary me-3">
                    <i class="fa-solid fa-user-pen"></i>
                  </a>
                  <a href="?delete=<?= $datos->ID_Cuenta ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta cuenta?');" title="Eliminar" class="text-danger">
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
            <input type="hidden" name="id_cuenta" id="editIdCuenta">
            <div class="mb-3">
              <label for="id_tipo" class="form-label">ID Tipo</label>
              <input type="text" class="form-control" name="id_tipo" id="editIdTipo">
            </div>
            <div class="mb-3">
              <label for="mail" class="form-label">Mail</label>
              <input type="text" class="form-control" name="mail" id="editMail">
            </div>
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
  <div class="modal fade" id="newAccountModal" tabindex="-1" aria-labelledby="newAccountModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="crud_cuentas.php" onsubmit="return validateTipo()">
        <div class="modal-header">
          <h5 class="modal-title" id="newAccountModalLabel">Agregar Nueva Cuenta</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="id_tipo" class="form-label">ID Tipo</label>
            <input type="text" class="form-control" name="id_tipo" id="id_tipo" required>
            <small id="id_tipo_error" class="text-danger" style="display:none;">El ID Tipo debe ser 1, 2 o 3.</small>
          </div>
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

  <footer class="footer light-background">
    <div class="container copyright text-center">
      <p>© 2024 <strong class="px-1 sitename">Historia Clinica Digital</strong> <span>Todos los derechos reservados</span></p>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script>
    function editRecord(id, tipo, mail) {
      document.getElementById('editIdCuenta').value = id;
      document.getElementById('editIdTipo').value = tipo;
      document.getElementById('editMail').value = mail;
      new bootstrap.Modal(document.getElementById('editModal')).show();
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

  <!-- PHP Funcionalidad de Backend -->
  <?php
  include "conexion.php";

  // Manejo de eliminación
  if (isset($_GET['delete'])) {
      $id_cuenta = intval($_GET['delete']);
      $stmt = $conexion->prepare("DELETE FROM cuentas WHERE ID_Cuenta = ?");
      $stmt->bind_param("i", $id_cuenta);

      try {
          $stmt->execute();
          echo "<script>alert('Cuenta eliminada exitosamente'); window.location.href='crud_cuentas.php';</script>";
      } catch (mysqli_sql_exception $e) {
          echo "<script>alert('No se puede eliminar la cuenta porque tiene datos relacionados.');</script>";
      }
      $stmt->close();
  }

  // Actualización de datos
  if (isset($_POST['actualizar'])) {
      $id_cuenta = intval($_POST['id_cuenta']);
      $id_tipo = $_POST['id_tipo'];
      $mail = $_POST['mail'];

      $stmt = $conexion->prepare("UPDATE cuentas SET ID_Tipo = ?, Mail = ? WHERE ID_Cuenta = ?");
      $stmt->bind_param("isi", $id_tipo, $mail, $id_cuenta);

      if ($stmt->execute()) {
          echo "<script>alert('Cuenta actualizada exitosamente');</script>";
          echo "<script>window.location.href = 'crud_cuentas.php';</script>";
      } else {
          echo "<script>alert('Error al actualizar la cuenta');</script>";
      }
      $stmt->close();
  }

  // Inserción de nueva cuenta
  if (isset($_POST['guardar_cuenta'])) {
      $id_tipo = $_POST['id_tipo'];
      $mail = $_POST['mail'];
      $stmt = $conexion->prepare("INSERT INTO cuentas (ID_Tipo, Mail) VALUES (?, ?)");
      $stmt->bind_param("is", $id_tipo, $mail);

      if ($stmt->execute()) {
          echo "<script>alert('Cuenta agregada exitosamente'); window.location.href='crud_cuentas.php';</script>";
      } else {
          echo "<script>alert('Error al agregar la cuenta');</script>";
      }
      $stmt->close();
      $conexion->close();
  }
  ?>
</body>
</html>
