<?php
session_start();

require 'conexion.php';

// TEST ONLY
//$_SESSION['ID_Cuenta'] = 30;


// Verifica si el usuario está autenticado
if (!isset($_SESSION['ID_Cuenta'])) {
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
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <!-- <img src="assets/img/logo.png" alt=""> -->
          <h1 class="sitename">Historia Clínica Digital</h1>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="index.php" class="active">Inicio<br></a></li>
            <li><a href="perfil.php">Mi Perfil</a></li>
            <li><a href="consulta.php">Consultas</a></li>
            <li class="dropdown"><a href="crud.php"><span>CRUD</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
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

    <!-- Hero Section -->
    <section id="hero" class="hero section light-background">

      <img src="assets/img/hero-bg.jpg" alt="" data-aos="fade-in">

      <div class="container position-relative">

        <div class="welcome position-relative" data-aos="fade-down" data-aos-delay="100">
          <h2>MI HISTORIA CLÍNICA</h2>
          <p>Toda tu información médica en un solo lugar</p>
        </div><!-- End Welcome -->

        <div class="content row gy-4">
          <div class="col-lg-4 d-flex align-items-stretch">
            <div class="why-box" data-aos="zoom-out" data-aos-delay="200">
              <h3>¿Qué es Historia Clínica Digital?</h3>
              <p>
                La Historia Clínica Digital es un sistema integral que permite a los pacientes y profesionales de la salud acceder y gestionar la información médica de forma segura y eficiente. Nuestro objetivo es mejorar la calidad de la atención y facilitar la comunicación entre todos los actores del sistema de salud.
              </p>
              <div class="text-center">
                <a href="#about" class="more-btn"><span>Conocé Más</span> <i class="bi bi-chevron-right"></i></a>
              </div>
            </div>
          </div><!-- End Why Box -->

          <div class="col-lg-8 d-flex align-items-stretch">
            <div class="d-flex flex-column justify-content-center">
              <div class="row gy-4">

                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box" data-aos="zoom-out" data-aos-delay="300">
                    <i class="bi bi-clipboard-data"></i>
                    <h4>Protección de Datos</h4>
                    <p>Cumplimos con los más altos estándares de seguridad y protección de datos médicos.</p>
                  </div>
                </div><!-- End Icon Box -->

                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box" data-aos="zoom-out" data-aos-delay="400">
                    <i class="bi bi-gem"></i>
                    <h4>Accesibilidad</h4>
                    <p>Accede a tus informes, resultados y antecedentes en cualquier momento y lugar.</p>
                  </div>
                </div><!-- End Icon Box -->

                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box" data-aos="zoom-out" data-aos-delay="500">
                    <i class="bi bi-inboxes"></i>
                    <h4>Interoperabilidad</h4>
                    <p>Integración con múltiples sistemas para asegurar un flujo de información continuo y eficiente.</p>
                  </div>
                </div><!-- End Icon Box -->

              </div>
            </div>
          </div>
        </div><!-- End  Content-->

      </div>

    </section><!-- /Hero Section -->




    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container">

        <div class="row gy-4 gx-5">

          <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="200">
            <img src="assets/img/about.jpg" class="img-fluid" alt="">
          </div>

          <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
            <h3>Sobre nosotros</h3>
            <p>
              La Historia Clínica Digital es una plataforma innovadora diseñada para optimizar la gestión de la información médica.
              Nuestro objetivo es proporcionar a pacientes y profesionales de la salud un acceso seguro y eficiente a los datos clínicos.
              Facilitar el intercambio de información entre diferentes proveedores de salud es esencial para mejorar la atención y los resultados clínicos.</p>
            <ul>
              <li>
                <i class="fa-solid fa-vial-circle-check"></i>
                <div>
                  <h5>Mejora en la eficiencia de los servicios de salud </h5>
                  <p>La digitalización de los registros médicos permite un flujo de información más ágil, reduciendo los tiempos de espera y optimizando los procesos administrativos.</p>
                </div>
              </li>
              <li>
                <i class="fa-solid fa-pump-medical"></i>
                <div>
                  <h5>Acceso centralizado a la información médica
                  </h5>
                  <p>Los profesionales pueden consultar el historial clínico de los pacientes de manera rápida, garantizando una atención más informada y personalizada.</p>
                </div>
              </li>
              <li>
                <i class="fa-solid fa-heart-circle-xmark"></i>
                <div>
                  <h5>Fortalecimiento de la colaboración interprofesional
                  </h5>
                  <p>Fomentamos la comunicación entre diferentes especialistas para asegurar un enfoque integral en el tratamiento y seguimiento de los pacientes.</p>
                </div>
              </li>
            </ul>
          </div>

        </div>

      </div>

    </section><!-- /About Section -->

    <!-- Stats Section -->
    <section id="stats" class="stats section light-background">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="fa-solid fa-user-doctor"></i>
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="8" data-purecounter-duration="1" class="purecounter"></span>
              <p>Profesionales</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="fa-regular fa-hospital"></i>
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="5" data-purecounter-duration="1" class="purecounter"></span>
              <p>Especialidades</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="fas fa-flask"></i>
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="12" data-purecounter-duration="1" class="purecounter"></span>
              <p>Estudios</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="fas fa-award"></i>
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="150" data-purecounter-duration="1" class="purecounter"></span>
              <p>Awards</p>
            </div>
          </div><!-- End Stats Item -->

        </div>

      </div>

    </section><!-- /Stats Section -->

    <!-- Departments Section -->
    <section id="departments" class="departments section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Especialidades</h2>
        <p>Nuestra red de servicios abarca diversas especialidades médicas, garantizando una atención de calidad en todas las áreas.

        </p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">
          <div class="col-lg-3">
            <ul class="nav nav-tabs flex-column">
              <li class="nav-item">
                <a class="nav-link active show" data-bs-toggle="tab" href="#departments-tab-1">Cardiología</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#departments-tab-2">Neurología</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#departments-tab-3">Traumatología</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#departments-tab-4">Pediatría</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#departments-tab-5">Oftalmología</a>
              </li>
            </ul>
          </div>
          <div class="col-lg-9 mt-4 mt-lg-0">
            <div class="tab-content">
              <div class="tab-pane active show" id="departments-tab-1">
                <div class="row">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <h3>Cardiología</h3>
                    <p class="fst-italic">La Cardiología se dedica al diagnóstico y tratamiento de enfermedades del corazón y el sistema circulatorio. Nuestro equipo de cardiólogos trabaja con tecnología avanzada para ofrecer cuidados personalizados.</p>
                    <p>La salud cardiovascular es fundamental para el bienestar general. Nuestros especialistas están comprometidos en proporcionar tratamientos efectivos y en la prevención de enfermedades cardíacas.</p>
                  </div>
                  <div class="col-lg-4 text-center order-1 order-lg-2">
                    <img src="assets/img/departments-1.jpg" alt="" class="img-fluid">
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="departments-tab-2">
                <div class="row">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <h3>Neurología</h3>
                    <p class="fst-italic">La Neurología abarca el diagnóstico y tratamiento de trastornos del sistema nervioso. Contamos con un equipo de expertos en el manejo de condiciones neurológicas complejas.</p>
                    <p>Nos enfocamos en ofrecer un diagnóstico preciso y un plan de tratamiento adaptado a las necesidades del paciente, utilizando técnicas avanzadas y un enfoque multidisciplinario.</p>
                  </div>
                  <div class="col-lg-4 text-center order-1 order-lg-2">
                    <img src="assets/img/departments-2.jpg" alt="" class="img-fluid">
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="departments-tab-3">
                <div class="row">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <h3>Traumatología</h3>
                    <p class="fst-italic">La Traumatología se especializa en el tratamiento de lesiones y trastornos musculoesqueléticos. Nuestro equipo está capacitado para manejar desde lesiones deportivas hasta traumas complejos.</p>
                    <p>Brindamos atención integral y una rehabilitación adecuada para asegurar la mejor recuperación posible, priorizando siempre la salud y bienestar del paciente.</p>
                  </div>
                  <div class="col-lg-4 text-center order-1 order-lg-2">
                    <img src="assets/img/departments-3.jpg" alt="" class="img-fluid">
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="departments-tab-4">
                <div class="row">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <h3>Pediatría</h3>
                    <p class="fst-italic">La Pediatría se enfoca en la atención médica de los más jóvenes, desde recién nacidos hasta adolescentes. Nuestro objetivo es promover la salud infantil y garantizar un desarrollo óptimo.</p>
                    <p>Ofrecemos un ambiente acogedor y profesional, donde los padres pueden confiar en que sus hijos recibirán la mejor atención posible en cada etapa de su crecimiento.</p>
                  </div>
                  <div class="col-lg-4 text-center order-1 order-lg-2">
                    <img src="assets/img/departments-4.jpg" alt="" class="img-fluid">
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="departments-tab-5">
                <div class="row">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <h3>Oftalmología</h3>
                    <p class="fst-italic">La Oftalmología se dedica a la salud ocular, diagnosticando y tratando problemas visuales. Nuestros oftalmólogos utilizan tecnología de vanguardia para ofrecer soluciones efectivas.</p>
                    <p>Desde exámenes de rutina hasta cirugías complejas, estamos comprometidos en mejorar la salud visual de nuestros pacientes con un enfoque en la prevención y la educación.</p>
                  </div>
                  <div class="col-lg-4 text-center order-1 order-lg-2">
                    <img src="assets/img/departments-5.jpg" alt="" class="img-fluid">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /Departments Section -->

    <!-- Faq Section -->
    <section id="faq" class="faq section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Preguntas Frecuentes</h2>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row justify-content-center">

          <div class="col-lg-10" data-aos="fade-up" data-aos-delay="100">

            <div class="faq-container">

              <div class="faq-item">
                <h3>¿Qué es Historia Clínica Digital?
                </h3>
                <div class="faq-content">
                  <p>Historia Clínica Digital es una herramienta diseñada para centralizar y facilitar el acceso a la información médica de los pacientes, asegurando una atención más efectiva y coordinada en todo el país.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>¿Cuál es el rol del médico en el uso de Historia Clínica Digital?
                </h3>
                <div class="faq-content">
                  <p>El médico se encarga de documentar exhaustivamente cada consulta y procedimiento en el sistema, permitiendo que otros profesionales tengan acceso al historial médico del paciente en cualquier momento.

                  </p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>¿Qué papel juegan los ciudadanos en Historia Clínica Digital?
                </h3>
                <div class="faq-content">
                  <p>Los ciudadanos son fundamentales en este sistema, ya que tienen el control sobre quién puede acceder a su información médica, asegurando así su privacidad y confianza en el sistema de salud.

                  </p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>¿Cómo se garantiza la privacidad de la información en Historia Clínica Digital?
                </h3>
                <div class="faq-content">
                  <p>Se implementan estrictas políticas de seguridad que limitan el acceso a información sensible solo a personal autorizado y que requieren consentimiento del paciente para el intercambio de datos.

                  </p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>¿Por qué es importante la digitalización de los registros médicos?
                </h3>
                <div class="faq-content">
                  <p>La digitalización es crucial para la mejora continua del sistema de salud, ya que permite a los pacientes y profesionales acceder a información en tiempo real, favoreciendo una toma de decisiones más efectiva y una atención más coordinada.

                  </p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

            </div>

          </div><!-- End Faq Column-->

        </div>

      </div>

    </section><!-- /Faq Section -->
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