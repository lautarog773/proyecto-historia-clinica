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

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body class="index-page">

  <header id="header" class="header sticky-top">

    <div class="branding d-flex align-items-center">

      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center me-auto">
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <!-- <img src="assets/img/logo.png" alt=""> -->
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

    <!-- Hero Section -->
    <section id="hero" class="hero section light-background">

      <img src="assets/img/hero-bg.jpg" alt="" data-aos="fade-in">

      <div class="container position-relative">

        <div class="welcome position-relative" data-aos="fade-down" data-aos-delay="100">
          
        </div><!-- End Welcome -->

        

    <!-- Contact Section -->
    <section id="contact" class="contact section">
      <div class="container-fluid row">
        <div class="container section-title" data-aos="fade-up">
          <h2>CRUD</h2>
        </div><!-- End Section Title -->
          <form class= "col-4 p-3">
              
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Nombre</label>
                <input type="text" class="form-control" name= "nombre">
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Apellido</label>
                <input type="text" class="form-control" name= "apellido">
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">DNI</label>
                <input type="text" class="form-control" name= "dni">
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" name= "fechanac">
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Mail</label>
                <input type="email" class="form-control" name= "mail">
              </div>
              
              <button type="submit" class="btn btn-primary" name="buscar" value="ok">Buscar</button>
          </form>

          <div class="col-8 p-4">
            <table class="table">
              <thead class="bg-info">
                <tr>
                  <th scope="col">DNI</th>
                  <th scope="col">Nombre</th>
                  <th scope="col">Apellido</th>
                  <th scope="col">Fecha de Nacimiento</th>
                  <th scope="col">Mail</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>Mark</td>
                  <td>Otto</td>
                  <td>14/10/1998</td>
                  <td>pp@gmail.com</td>
                  <td>
                    <a href=""><i class="fa-solid fa-user-pen"></i></a>
                    <a href=""><i class="fa-solid fa-trash"></i></a>

                  </td>
                </tr>
                <tr>
                  <th scope="row">1</th>
                  <td>Ana</td>
                  <td>Test</td>
                  <td>2/10/1993</td>
                  <td>pp2@gmail.com</td>
                  <td>
                    <a href=""><i class="fa-solid fa-user-pen"></i></a>
                    <a href=""><i class="fa-solid fa-trash"></i></a>

                  </td>
                </tr>
                
              </tbody>
            </table>
          </div>

          
        
      </div>


      

    </section><!-- /Contact Section -->

  </main>

  <footer class="footer light-background">
    <div class="container copyright text-center">
      <p>© 2024 <strong class="px-1 sitename">Historia Clinica Digital</strong> <span>Todos los derechos reservados </span></p>
    </div>
  </footer>

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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>