<?php
session_start();

require 'conexion.php';

// TEST ONLY
//$SESSION['ID_Cuenta'] = 30;


// Verifica si el usuario está autenticado
if (!isset($_SESSION['ID_Cuenta'])) {
  header("Location: form_login.php");
  exit();
}


// Obtener información del usuario
$id_cuenta = $_SESSION['ID_Cuenta'];

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


  if ($tipo_usuario == 1) {
    $nombre_usuario = $usuario['nombre_paciente'];
  } elseif ($tipo_usuario == 2) {
    $nombre_usuario = $usuario['nombre_medico'];
  }
} else {
  // Si no se encuentra el usuario, redirigir a login
  header("Location: login.php");
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
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

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
      <a href="index.php" class="logo d-flex align-items-center me-auto">
        <h1 class="sitename">Historia Clínica Digital</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php">Inicio</a></li>
          <li><a href="perfil.php">Mi Perfil</a></li>
          <li><a href="consulta.php">Consultas</a></li>
          <?php if ($tipo_usuario == 3) : ?>
              <li class="dropdown"><a href="crud.php"><span>CRUD</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
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

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Contacto</h2>
      </div><!-- End Section Title -->

      <div class="mb-5" data-aos="fade-up" data-aos-delay="200">
        <iframe style="border:0; width: 100%; height: 270px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d13130.23587367068!2d-58.602031!3d-34.6405839!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95bc951c0fe2d9f5%3A0x9f1c540898efecbe!2sUTN%20HAEDO!5e0!3m2!1ses-419!2sar!4v1730299638219!5m2!1ses-419!2sar" frameborder="0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div><!-- End Google Maps -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-4">
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-geo-alt flex-shrink-0"></i>
              <div>
                <h3>Locación</h3>
                <p>París 532, Haedo, Provincia de Buenos Aires, CP1706</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-telephone flex-shrink-0"></i>
              <div>
                <h3>Teléfono</h3>
                <p>011 4455 6677</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
              <i class="bi bi-envelope flex-shrink-0"></i>
              <div>
                <h3>Correo electrónico</h3>
                <p>info@historiaclinica.com</p>
              </div>
            </div><!-- End Info Item -->

          </div>

          <div class="col-lg-8">
            <form action="guardar_contacto.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
              <div class="row gy-4">
                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Nombre y apellido" required="">
                </div>
                <div class="col-md-6 ">
                  <input type="email" class="form-control" name="email" placeholder="Email" required="">
                </div>
                <div class="col-md-12">
                  <input type="text" class="form-control" name="subject" placeholder="Asunto" required="">
                </div>
                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="6" placeholder="Mensaje" required=""></textarea>
                </div>
                <div class="col-md-12 text-center">
                  <div class="loading">Enviando</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Su mensaje fue enviado, gracias!</div>
                  <button type="submit">Enviar Mensaje</button>
                </div>
              </div>
            </form>
          </div>

        </div>

      </div>

    </section><!-- /Contact Section -->

  </main>
  
  <footer class="footer light-background">
    <div class="container copyright text-center">
      <p>© 2024 <strong class="px-1 sitename">Historia Clinica Digital</strong> <span>Todos los derechos reservados </span></p>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>