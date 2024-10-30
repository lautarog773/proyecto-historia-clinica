<?php
include "conexion.php";

// Validar si se envió el formulario de actualización
if (isset($_POST['actualizar'])) {
    // Obtener los datos enviados desde el formulario
    $id_os = intval($_POST['id_os']);
    $nombre = $_POST['nombre'];

    // Preparar la consulta de actualización para evitar SQL Injection
    $stmt = $conexion->prepare("UPDATE obras_sociales SET Nombre = ? WHERE ID_OS = ?");
    $stmt->bind_param("si", $nombre, $id_os);

    // Ejecutar la consulta y verificar si se actualizó correctamente
    if ($stmt->execute()) {
        echo "<script>alert('Obra social actualizada exitosamente');</script>";
        echo "<script>window.location.href = 'crud_obras_sociales.php';</script>"; // Redirige al listado
    } else {
        echo "<script>alert('Error al actualizar la obra social');</script>";
    }

    $stmt->close();
}

// Obtener el id_os de forma segura para mostrar los datos en el formulario
$id_os = isset($_GET['id_cuenta']) ? intval($_GET['id_cuenta']) : 0;
$stmt = $conexion->prepare("SELECT * FROM obras_sociales WHERE ID_OS = ?");
$stmt->bind_param("i", $id_os);
$stmt->execute();
$result = $stmt->get_result();
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
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">

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
        <!-- Formulario de modificación -->
        <form method="POST" action="crud_obras_sociales_modificar.php" class="col-4 p-3 m-auto">
          <?php if ($datos = $result->fetch_object()) { ?>
            <div class="mb-3">
              <label for="id_os" class="form-label">ID OS</label>
              <input type="text" class="form-control" name="id_os" value="<?= $datos->ID_OS ?>" readonly>
            </div>
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" name="nombre" value="<?= $datos->Nombre ?>">
            </div>
          <?php } else { ?>
            <p>No se encontró la obra social.</p>
          <?php } ?>
          <button type="submit" class="btn btn-primary" name="actualizar" value="ok">Actualizar</button>
        </form>
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
