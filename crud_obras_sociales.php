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
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;500;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
        <li><a href="index.php">Inicio<br></a></li>
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
    <section id="contact" class="contact section">
      <div class="container-fluid row">
        <!-- Formulario de búsqueda -->
        <form method="GET" action="crud_obras_sociales.php" class="col-4 p-3">
          <div class="mb-3">
            <label for="id_cuenta" class="form-label">ID OS</label>
            <input type="text" class="form-control" name="id_cuenta" value="<?php echo isset($_GET['id_cuenta']) ? $_GET['id_cuenta'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" name="nombre" value="<?php echo isset($_GET['nombre']) ? $_GET['nombre'] : ''; ?>">
          </div>
          <button type="submit" class="btn btn-primary" name="buscar" value="ok">Buscar</button>
        </form>

        <!-- Tabla de resultados -->
        <div class="col-8 p-4">
          <table class="table">
            <thead class="bg-info">
              <tr>
                <th scope="col">ID OS</th>
                <th scope="col">Nombre</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              include "conexion.php";

              $id_cuenta = isset($_GET['id_cuenta']) ? $_GET['id_cuenta'] : '';
              $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';

              $query = "SELECT * FROM obras_sociales WHERE 1=1";
              $params = [];
              $types = "";

              if (!empty($id_cuenta)) {
                  $query .= " AND ID_OS LIKE ?";
                  $params[] = "%" . $id_cuenta . "%";
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
                  <td><?= $datos->ID_OS ?></td>
                  <td><?= $datos->Nombre ?></td>
                  <td>
                    <a href="#" onclick="editRecord(<?= $datos->ID_OS ?>, '<?= $datos->Nombre ?>')" title="Editar">
                      <i class="fa-solid fa-user-pen"></i>
                    </a>
                    <a href="?delete=<?= $datos->ID_OS ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta obra social?');" title="Eliminar">
                      <i class="fa-solid fa-trash"></i>
                    </a>
                  </td>
                </tr>
              <?php }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </main>

  <!-- Modal para editar -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="POST" action="crud_obras_sociales.php">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Editar Obra Social</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id_os" id="editIdOs">
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

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  
  <script>
    function editRecord(id, nombre) {
      document.getElementById('editIdOs').value = id;
      document.getElementById('editNombre').value = nombre;
      new bootstrap.Modal(document.getElementById('editModal')).show();
    }
  </script>

  <?php
  // Manejo de eliminación con control de error
  if (isset($_GET['delete'])) {
      $id_os = intval($_GET['delete']);
      $stmt = $conexion->prepare("DELETE FROM obras_sociales WHERE ID_OS = ?");
      $stmt->bind_param("i", $id_os);

      try {
          $stmt->execute();
          echo "<script>alert('Obra social eliminada exitosamente'); window.location.href='crud_obras_sociales.php';</script>";
      } catch (mysqli_sql_exception $e) {
          echo "<script>alert('No se puede eliminar la obra social porque tiene datos relacionados.');</script>";
      }
      $stmt->close();
  }

  // Actualización de datos
  if (isset($_POST['actualizar'])) {
      $id_os = intval($_POST['id_os']);
      $nombre = $_POST['nombre'];

      $stmt = $conexion->prepare("UPDATE obras_sociales SET Nombre = ? WHERE ID_OS = ?");
      $stmt->bind_param("si", $nombre, $id_os);

      if ($stmt->execute()) {
          echo "<script>alert('Obra social actualizada exitosamente'); window.location.href='crud_obras_sociales.php';</script>";
      } else {
          echo "<script>alert('Error al actualizar la obra social');</script>";
      }
      $stmt->close();
  }
  ?>
</body>
</html>
