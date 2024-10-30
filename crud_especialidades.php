
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
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">

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
    <div class="branding d-flex align-items-center">
      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center me-auto">
          <h1 class="sitename">Historia Clínica Digital</h1>
        </a>
        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="logout.php">Cerrar Sesión</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
      </div>
    </div>
  </header>

  <main class="main">



    <section id="contact" class="contact section">

      <div class="container-fluid row">

        <!-- Formulario de búsqueda -->
        <form method="GET" action="crud_especialidades.php" class="col-4 p-3">
          <div class="mb-3">
            <label for="id_cuenta" class="form-label">ID Especialidad</label>
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
                <th scope="col">ID Especialidad</th>
                <th scope="col">Nombre</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <?php
              include "conexion.php";

              // Capturar los valores de búsqueda
              $id_cuenta = isset($_GET['id_cuenta']) ? $_GET['id_cuenta'] : '';
              $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';

              // Construir la consulta SQL con los filtros
              $query = "SELECT * FROM especialidades WHERE 1=1";
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

              // Ejecutar la consulta
              if (!empty($params)) {
                  $stmt = $conexion->prepare($query);
                  $stmt->bind_param($types, ...$params);
                  $stmt->execute();
                  $result = $stmt->get_result();
              } else {
                  $result = $conexion->query($query);
              }

              // Mostrar los datos
              while ($datos = $result->fetch_object()) { ?>
                <tr>
                  <td><?= $datos->ID_Especialidad ?></td>
                  <td><?= $datos->Nombre ?></td>
                  <td>
                    <a href="crud_especialidades_modificar.php?id_cuenta=<?= $datos->ID_Especialidad ?>"><i class="fa-solid fa-user-pen"></i></a>
                    <a href="crud_especialidades_eliminar.php?id=<?= $datos->ID_Especialidad ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta especialidad?');"><i class="fa-solid fa-trash"></i></a>

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

  <footer class="footer light-background">
    <div class="container copyright text-center">
      <p>© 2024 <strong class="px-1 sitename">Historia Clinica Digital</strong> <span>Todos los derechos reservados</span></p>
    </div>
  </footer>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>
</html>
