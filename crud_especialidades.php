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
        <h2>CRUD Especialidades</h2>
      </div>

      <!-- Sección de acciones (Botón + Formulario de búsqueda) -->
      <div class="row mb-4 align-items-center">
        <!-- Botón "Nueva Especialidad" -->
        <div class="col-md-3 col-12 mb-2 mb-md-0">
          <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#newEspModal">
            Nueva Especialidad
          </button>
        </div>

        <!-- Formulario de búsqueda -->
        <form method="GET" action="crud_especialidades.php" class="col-md-9 col-12 row gx-2">
          <div class="col-md-5 col-12 mb-2 mb-md-0">
            <input type="text" class="form-control" name="id_especialidad" placeholder="🔍 ID Especialidad" value="<?php echo isset($_GET['id_especialidad']) ? $_GET['id_especialidad'] : ''; ?>">
          </div>
          <div class="col-md-5 col-12 mb-2 mb-md-0">
            <input type="text" class="form-control" name="nombre" placeholder="🔍 Nombre" value="<?php echo isset($_GET['nombre']) ? $_GET['nombre'] : ''; ?>">
          </div>
          <div class="col-md-2 col-12">
            <button type="submit" class="btn btn-primary w-100" name="buscar" value="ok">Buscar</button>
          </div>
        </form>
      </div>

      <!-- Tabla de resultados -->
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead class="bg-info text-white">
            <tr>
              <th scope="col">ID Especialidad</th>
              <th scope="col">Nombre</th>
              <th scope="col">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include "conexion.php";
            $id_especialidad = isset($_GET['id_especialidad']) ? $_GET['id_especialidad'] : '';
            $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
            $query = "SELECT * FROM especialidades WHERE 1=1";
            $params = [];
            $types = "";

            if (!empty($id_especialidad)) {
                $query .= " AND ID_Especialidad LIKE ?";
                $params[] = "%" . $id_especialidad . "%";
                $types .= "s";
            }
            if (!empty($nombre)) {
                $query .= " AND Nombre LIKE ?";
                $params[] = "%" . $nombre . "%";
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
                <td><?= $datos->ID_Especialidad ?></td>
                <td><?= $datos->Nombre ?></td>
                <td>
                  <a href="#" onclick="editRecord(<?= $datos->ID_Especialidad ?>, '<?= $datos->Nombre ?>')" title="Editar" class="text-primary me-3">
                    <i class="fa-solid fa-user-pen"></i>
                  </a>
                  <a href="?delete=<?= $datos->ID_Especialidad ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta especialidad?');" title="Eliminar" class="text-danger">
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
        <form method="POST" action="crud_especialidades.php">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Editar Especialidad</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id_especialidad" id="editIdEsp">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" name="nombre" id="editNombre">
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
  <div class="modal fade" id="newEspModal" tabindex="-1" aria-labelledby="newEspModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="POST" action="crud_especialidades.php">
          <div class="modal-header">
            <h5 class="modal-title" id="newEspModalLabel">Agregar Nueva Especialidad</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="nombre_especialidad" class="form-label">Nombre de la Especialidad</label>
              <input type="text" class="form-control" name="nombre_especialidad" id="nombre_especialidad" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary" name="guardar_especialidad">Guardar</button>
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
    function editRecord(id, nombre) {
      document.getElementById('editIdEsp').value = id;
      document.getElementById('editNombre').value = nombre;
      new bootstrap.Modal(document.getElementById('editModal')).show();
    }
  </script>

  <!-- PHP Funcionalidad de Backend -->
  <?php
  include "conexion.php";

  // Manejo de eliminación
  if (isset($_GET['delete'])) {
      $id_especialidad = intval($_GET['delete']);
      $stmt = $conexion->prepare("DELETE FROM especialidades WHERE ID_Especialidad = ?");
      $stmt->bind_param("i", $id_especialidad);

      try {
          $stmt->execute();
          echo "<script>alert('Especialidad eliminada exitosamente'); window.location.href='crud_especialidades.php';</script>";
      } catch (mysqli_sql_exception $e) {
          echo "<script>alert('No se puede eliminar la especialidad porque tiene datos relacionados.');</script>";
      }
      $stmt->close();
  }

  // Actualización de datos
  if (isset($_POST['actualizar'])) {
      $id_especialidad = intval($_POST['id_especialidad']);
      $nombre = $_POST['nombre'];

      $stmt = $conexion->prepare("UPDATE especialidades SET Nombre = ? WHERE ID_Especialidad = ?");
      $stmt->bind_param("si", $nombre, $id_especialidad);

      if ($stmt->execute()) {
          echo "<script>alert('Especialidad actualizada exitosamente');</script>";
          echo "<script>window.location.href = 'crud_especialidades.php';</script>";
      } else {
          echo "<script>alert('Error al actualizar la especialidad');</script>";
      }
      $stmt->close();
  }

  // Inserción de nueva especialidad
  if (isset($_POST['guardar_especialidad'])) {
      $nombre_especialidad = $_POST['nombre_especialidad'];
      $stmt = $conexion->prepare("INSERT INTO especialidades (Nombre) VALUES (?)");
      $stmt->bind_param("s", $nombre_especialidad);

      if ($stmt->execute()) {
          echo "<script>alert('Especialidad agregada exitosamente'); window.location.href='crud_especialidades.php';</script>";
      } else {
          echo "<script>alert('Error al agregar la especialidad');</script>";
      }
      $stmt->close();
      $conexion->close();
  }
  ?>
</body>
</html>
