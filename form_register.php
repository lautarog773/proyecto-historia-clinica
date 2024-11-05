<?php
// Incluimos el archivo de conexión
include 'conexion.php';

// Consulta para obtener las opciones de obra social
$query = "SELECT ID_OS, Nombre FROM obras_sociales";
$result = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport"> <!--configura la visualización en dispositivos móviles,
  asegurando que el diseño se adapte al ancho de la pantalla.-->
  <title>Registro - Historia Clínica Digital</title>
  <meta name="description" content="">
  <meta name="keywords" content=""><!--Espacios reservados para la descripción y las palabras clave del sitio, 
  útiles para SEO (optimización en motores de búsqueda)-->

  <!-- Favicons --> 
   <!--Establecen el icono que se muestra en la pestaña del navegador y en dispositivos Apple cuando se añade a la pantalla de inicio-->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <!-- Conecta con Google Fonts para cargar las fuentes Roboto, Poppins y Raleway, mejorando la tipografía del sitio -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
   <!--Importa hojas de estilo CSS de librerías externas como Bootstrap, AOS (Animate On Scroll), 
   FontAwesome (íconos), GLightbox (ventanas emergentes), y Swiper (deslizadores)-->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet"> <!--Carga el archivo CSS principal que contiene estilos específicos del sitio-->

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
            <li><a href="contact.php">Contacto</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
      </div>
    </div>
  </header>

  <main class="main">
    <!-- Contact Section -->
    <section id="login" class="contact-section">
    <!-- Define una sección de contacto/inicio de sesión, usando el atributo id="login" y la clase form section. 
     Esto permite identificar y aplicar estilos a esta sección.-->

      <!-- Section Title -->
      <div class="container d-flex justify-content-center" data-aos="fade-up">
        <div class="col-md-8 col-lg-6 p-4 shadow rounded bg-white">
          <div class="section-title text-center"><!--Muestra el título "Registro" de la sección. 
        El atributo data-aos="fade-up" permite animar el título al deslizar la página 
        (usando la biblioteca AOS para efectos de animación). -->
        <h2>Registro</h2>
      </div><!-- End Section Title -->

  <form id="form_register" action="register.php" method="post" data-aos="fade-up" data-aos-delay="200">
    <!-- Nombre -->
    <div class="m-auto">
<!-- <label for="nombre" class="form-label">Nombre</label>-->
      <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa tu nombre" required>
    </div><br />

    <!-- Apellido -->
    <div class="m-auto">
      <!-- <label for="apellido" class="form-label">Apellido</label>-->
      <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Ingresa tu apellido" required>
    </div><br />

    <!-- DNI -->
    <div class="m-auto">
      <!-- <label for="dni" class="form-label">DNI</label>-->
      <input type="number" class="form-control" id="dni" name="dni" placeholder="Ingresa tu DNI" required>
    </div><br />

    <div class="m-auto">
    <!-- <label for="obrasocial">Obra Social</label>-->
        <select name="obrasocial" class="form-select" id="obrasocial" required>
            <option value="">Seleccione una obra social</option>
            <?php while ($row = $result->fetch_assoc()): ?>
                <option value="<?= $row['ID_OS'] ?>"><?= htmlspecialchars($row['Nombre']) ?></option>
            <?php endwhile; ?>
        </select>
        </div><br>
    <!-- Email -->
    <div class="m-auto">
      <!-- <label for="email" class="form-label">Correo Electrónico</label>-->
      <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu correo electronico" required>
    </div><br />

    <!-- Contraseña -->
    <div class="m-auto">
      <!-- <label for="password" class="form-label">Contraseña</label>-->
      <input type="password" class="form-control" id="pass" name="pass" placeholder="Ingresa tu contraseña" required>
    </div><br/>

    <div class="col-md-12 text-center">
                <input name="tyc" type="checkbox" value="si" checked="checked" required/> Acepta términos y condiciones.
                </div><br/>
    <!-- Botón Registrarse -->
    <button type="submit" class="btn btn-primary w-100">Registrarse</button>
    
    <div id="passwordError" class="alert alert-danger" style="display:none;">La nueva contraseña no cumple con los requisitos de seguridad.</div>
  </form>
  <br/>
  <a href="form_login.php">Ya tenes cuenta? Iniciar Sesion</a>  


  </div>
  </div>
        
    </section>

  </main>

  <footer class="footer light-background"><!--Define el pie de página con información de derechos de autor. -->
    <div class="container copyright text-center">
      <p>© 2024 <strong class="px-1 sitename">Historia Clinica Digital</strong> <span>Todos los derechos reservados </span></p><!-- -->
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a> <!-- -->
  <!-- Botón que permite al usuario regresar rápidamente a la parte superior de la página -->
  <!-- Preloader -->
  <div id="preloader"></div><!-- Contenedor para un efecto de precarga que puede mostrarse mientras la página carga completamente -->

  <!-- Vendor JS Files --><!-- -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <!-- Archivos JS de Bootstrap, validación de formularios, 
  AOS (animación), GLightbox, PureCounter (contador animado), y Swiper (para carruseles). -->

  <!-- Main JS File --> <!-- Archivo JavaScript personalizado que controla el comportamiento del sitio-->
  <script src="assets/js/main.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      document.getElementById('form_register').addEventListener('submit', function (e) {
       const password = document.getElementById('pass').value;
       const passwordError = document.getElementById('passwordError');

       // validar la contraseña
       const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;

       if (!passwordRegex.test(password)) {
           e.preventDefault(); // Detiene el envío del formulario si la contraseña no cumple
           passwordError.style.display = 'block';

           setTimeout(() => {
               passwordError.style.display = 'none';
           }, 5000);
       }
     });
    });
  </script>
</body>

</html>