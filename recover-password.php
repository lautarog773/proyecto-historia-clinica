<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Recuperar Contraseña - Historia Clínica Digital</title>

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts y CSS -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
  <style>
    .alert {
      display: none;
      margin-top: 10px;
    }
  </style>
</head>

<body class="index-page">

  <header id="header" class="header sticky-top">
    <div class="branding d-flex align-items-center">
      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="index.php" class="logo d-flex align-items-center me-auto">
          <h1 class="sitename">Historia Clínica Digital</h1>
        </a>
      </div>
    </div>
  </header>

  <main class="main">
    <section id="recuperar" class="contact section">
      <div class="container d-flex justify-content-center" data-aos="fade-up">
        <div class="col-md-8 col-lg-6 p-4 shadow rounded bg-white">
          <div class="section-title text-center">
            <h2>Recuperar Contraseña</h2>
          </div>

          <form id="passwordForm" action="process-password.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
            <div class="row gy-4">
              <div class="col-md-12">
                <input type="email" class="form-control" name="email" placeholder="Ingresa tu correo electrónico" required>
              </div>

              <div class="col-md-12">
                <input type="text" class="form-control" name="dni" placeholder="Ingrese su DNI" required>
              </div>

              <div class="col-md-12">
                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Nueva Contraseña" required>
              </div>

              <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Modificar Contraseña</button>
              </div>

              <div id="successMessage" class="alert alert-success">Contraseña actualizada con éxito.</div>
              <div id="errorMessage" class="alert alert-danger">El DNI no coincide con el correo proporcionado.</div>
              <div id="passwordError" class="alert alert-danger">La nueva contraseña no cumple con los requisitos de seguridad.</div>
            </div>
          </form>
        </div>
      </div>
    </section>
  </main>

  <footer class="footer light-background">
    <div class="container text-center">
      <p>© 2024 <strong class="px-1 sitename">Historia Clínica Digital</strong> <span>Todos los derechos reservados</span></p>
    </div>
  </footer>

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/js/main.js"></script>

  <!-- mostrar mensajes temporales y validar la contraseña -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const urlParams = new URLSearchParams(window.location.search);
      if (urlParams.has('status')) {
        const status = urlParams.get('status');
        if (status === 'success') {
          document.getElementById('successMessage').style.display = 'block';
        } else if (status === 'error') {
          document.getElementById('errorMessage').style.display = 'block';
        }

        setTimeout(() => {
          document.getElementById('successMessage').style.display = 'none';
          document.getElementById('errorMessage').style.display = 'none';
        }, 5000);
      }

      // validar la contraseña antes de enviar el formulario
      document.getElementById('passwordForm').addEventListener('submit', function (e) {
        const password = document.getElementById('new_password').value;
        const passwordError = document.getElementById('passwordError');

        // validar la contraseña
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;

        if (!passwordRegex.test(password)) {
          e.preventDefault(); 
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
