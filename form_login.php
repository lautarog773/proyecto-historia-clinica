<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport"> <!--configura la visualización en dispositivos móviles,
  asegurando que el diseño se adapte al ancho de la pantalla.-->
  <title>Iniciar Sesion - Historia Clínica Digital</title>
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
    <!-- Define una sección de contacto/inicio de sesión, usando el atributo id="login" y la clase contact section. 
     Esto permite identificar y aplicar estilos a esta sección.-->

      <!-- Section Title -->
      <div class="container d-flex justify-content-center" data-aos="fade-up">
        <div class="col-md-8 col-lg-6 p-4 shadow rounded bg-white">
          <div class="section-title text-center"><!--Muestra el título "Bienvenido" de la sección. 
        El atributo data-aos="fade-up" permite animar el título al deslizar la página 
        (usando la biblioteca AOS para efectos de animación). -->
        <h2>Bienvenido</h2>
      </div><!-- End Section Title -->

      <!-- Spinner oculto inicialmente -->
    <div id="loading-spinner" class="spinner-border text-primary" role="status" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999;">
        <span class="visually-hidden">Cargando...</span>
    </div>
      
    <form id="login-form" onsubmit="loginUser(event)">
    <!-- Tus campos de formulario existentes -->
    <div class="m-auto">
        <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese su correo electrónico" required>
    </div><br />
    <div class="m-auto">
        <input type="password" class="form-control" id="pass" name="pass" placeholder="Ingresa tu contraseña" required>
    </div><br />
    <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
</form>

<script>
    async function loginUser(event) {
        event.preventDefault();

        // Mostrar el spinner
        document.getElementById("loading-spinner").style.display = "block";

        const email = document.getElementById("email").value;
        const pass = document.getElementById("pass").value;

        try {
            const response = await fetch('login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `email=${encodeURIComponent(email)}&pass=${encodeURIComponent(pass)}`
            });

            const result = await response.text();

            // Ocultar el spinner después de la respuesta
            document.getElementById("loading-spinner").style.display = "none";

            if (response.ok) {
                if (result.includes("incorrectas")) {
                    showAlert("Las credenciales son incorrectas: Usuario o contraseña no válidos");
                } else {
                    window.location.href = 'index.php';
                }
            } else {
                showAlert("Error en el servidor. Por favor, intenta de nuevo más tarde.");
            }
        } catch (error) {
            document.getElementById("loading-spinner").style.display = "none";
            showAlert("Error de conexión. Verifica tu conexión a internet e intenta nuevamente.");
        }
    }
</script>

    <br/>
            <a href="form_register.php">Registrarse</a> <br/>
            <a href="recover-password.php">Olvido su contraseña?</a>
          </div>

        </div>

    </section><!-- /Contact Section -->

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

<!-- Modal para mostrar mensajes de error -->
<div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="alertModalLabel">Advertencia</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="alertMessage">
        <!-- Mensaje de error se mostrará aquí -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
    function showAlert(message) {
        document.getElementById("alertMessage").textContent = message;
        var alertModal = new bootstrap.Modal(document.getElementById("alertModal"));
        alertModal.show();
    }
</script>


</body>

</html>