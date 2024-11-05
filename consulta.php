<?php
session_start();

require 'conexion.php';

// TEST ONLY
$SESSION['ID_Cuenta'] = 30;


// Verifica si el usuario está autenticado
if (!isset($_SESSION['ID_Cuenta'])) {
  header("Location: login.php");
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


// Consulta para obtener las consultas médicas del paciente
$sql_consultas = "SELECT d.id_profesional as id_doctor, d.nombre as nombre_doctor, d.apellido as apellido_doctor,
                  cm.Motivo as motivo, cm.Tratamiento as tratamiento, cm.Diagnostico as diagnostico,
                  cm.Comentarios as comentarios, cm.Fecha as fecha, e.Nombre as especialidad, e.ID_Especialidad as id_especialidad,
                  cm.id_consulta as ID_Consulta
                  FROM consultas_medicas cm
                  LEFT JOIN cuentas c ON c.ID_Paciente = cm.ID_Paciente
                  LEFT JOIN pacientes p ON c.ID_Paciente = p.ID_Paciente
                  LEFT JOIN doctores d ON cm.ID_Profesional = d.ID_Profesional
                  LEFT JOIN especialidades e ON d.ID_Especialidad = e.ID_Especialidad
                  WHERE c.ID_Cuenta = $id_cuenta
                  ORDER BY cm.Fecha DESC";

// Obtener los doctores y especialidades para los filtros
$query_doctores = "SELECT ID_Profesional, nombre, apellido FROM doctores";
$result_doctores = $conexion->query($query_doctores);

$query_especialidad = "SELECT ID_Especialidad, nombre FROM especialidades";
$result_especialidad = $conexion->query($query_especialidad);


// Ejecutar la consulta
$result_consultas = $conexion->query($sql_consultas);




// Obtener los pacientes para el desplegable
$sql_pacientes = "SELECT ID_Paciente, nombre, apellido FROM pacientes";
$result_pacientes = $conexion->query($sql_pacientes);

if ($result_pacientes === false) {
  die("Error al obtener los pacientes: " . $conexion->error);
}

// Obtener los pacientes para historial
$sql_pacientes = "SELECT ID_Paciente, nombre, apellido FROM pacientes";
$historial_pacientes = $conexion->query($sql_pacientes);

if ($historial_pacientes === false) {
  die("Error al obtener los pacientes: " . $conexion->error);
}


//Resultados
$consulta_result = '';
if (isset($_SESSION['consulta_result'])) {
  $consulta_result = $_SESSION['consulta_result'];
  unset($_SESSION['consulta_result']);
}

$historial_consultas = '';
if (isset($_SESSION['historial_consultas'])) {
  $historial_consultas = $_SESSION['historial_consultas'];
  unset($_SESSION['historial_consultas']);
}

$historial_estudios = '';
if (isset($_SESSION['historial_estudios'])) {
  $historial_estudios = $_SESSION['historial_estudios'];
  unset($_SESSION['historial_estudios']);
}

$tab_activa = isset($_SESSION['tab_activa']) ? $_SESSION['tab_activa'] : '';
unset($_SESSION['tab_activa']);


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
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;500;700&display=swap" rel="stylesheet">

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
            <li><a href="index.php">Inicio<br></a></li>
            <li><a href="perfil.php">Mi Perfil</a></li>
            <li><a href="consulta.php" class="active">Consultas</a></li>
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

        <a class="cta-btn d-none d-sm-block" href="logout.php">Cerrar Sesión</a>

      </div>

    </div>

  </header>

  <main class="main">
    <section id="principal" class="hero section light-background">
      <div class="container position-relative">

        <!-- Mensaje de bienvenida -->
        <div class="welcome position-relative text-center mb-4" data-aos="fade-down" data-aos-delay="100">
          <h2>Bienvenido, <?php echo $nombre_usuario; ?></h2>
          <?php if ($tipo_usuario == 1) : ?>
            <p>Aquí puedes revisar tus consultas médicas.</p>
          <?php elseif ($tipo_usuario == 2) : ?>
            <p>Aquí puedes gestionar y revisar la información de tus pacientes.</p>
          <?php endif; ?>
        </div>


        <!-- paciente -->
        <?php if ($tipo_usuario == 1) : ?>
          <div class="col-lg-12 d-flex flex-column align-items-center">
            <h4 class="mb-4">Consultas Médicas</h4>


            <!-- Formulario de búsqueda -->
            <div class="mb-4">
              <form id="busqueda-form" method="GET" action="" class="row g-2 align-items-center">

                <!-- Campo de búsqueda por motivo -->
                <div class="col-md-2">
                  <label for="motivo" class="form-label">Motivo</label>
                  <input type="text" class="form-control" placeholder="Motivo" name="motivo" id="motivo" aria-label="Buscar por motivo">
                </div>

                <!-- Selección de Doctor -->
                <div class="col-md-2">
                  <label for="doctor" class="form-label">Doctor</label>
                  <select class="form-select" id="doctor" name="doctor">
                    <option value="">Seleccionar</option>
                    <?php while ($doctor = $result_doctores->fetch_assoc()) : ?>
                      <option value="<?php echo $doctor['ID_Profesional']; ?>">
                        <?php echo $doctor['nombre'] . ' ' . $doctor['apellido']; ?>
                      </option>
                    <?php endwhile; ?>
                  </select>
                </div>

                <!-- Selección de Especialidad -->
                <div class="col-md-2">
                  <label for="especialidad" class="form-label">Especialidad</label>
                  <select class="form-select" id="especialidad" name="especialidad">
                    <option value="">Seleccionar</option>
                    <?php while ($especialidad = $result_especialidad->fetch_assoc()) : ?>
                      <option value="<?php echo $especialidad['ID_Especialidad']; ?>">
                        <?php echo $especialidad['nombre']; ?>
                      </option>
                    <?php endwhile; ?>
                  </select>
                </div>

                <!-- Campo de Fecha Desde -->
                <div class="col-md-2">
                  <label for="fecha_d" class="form-label">Fecha Desde</label>
                  <input type="date" class="form-control" name="fecha_d" id="fecha_d">
                </div>

                <!-- Campo de Fecha Hasta -->
                <div class="col-md-2">
                  <label for="fecha_h" class="form-label">Fecha Hasta</label>
                  <input type="date" class="form-control" name="fecha_h" id="fecha_h">
                </div>

                <!-- Botón de búsqueda -->
                <div class="col-auto d-flex align-items-end">
                  <button type="submit" class="btn btn-primary rounded-circle">
                    <i class="fas fa-search"></i>
                  </button>
                </div>

              </form>
            </div>



            <!-- Listado de consultas -->
            <div class="row col-md-12">
              <?php
              $motivo_busqueda = isset($_GET['motivo']) ? $_GET['motivo'] : '';
              $doctor_busqueda = isset($_GET['doctor']) ? $_GET['doctor'] : '';
              $especialidad_busqueda = isset($_GET['especialidad']) ? $_GET['especialidad'] : '';
              $fecha_d = isset($_GET['fecha_d']) ? $_GET['fecha_d'] : '';
              $fecha_h = isset($_GET['fecha_h']) ? $_GET['fecha_h'] : '';
              while ($consulta = $result_consultas->fetch_assoc()) :
                $motivo_valido = empty($motivo_busqueda) || stripos($consulta['motivo'], $motivo_busqueda) !== false;
                $doctor_valido = empty($doctor_busqueda) || $consulta['id_doctor'] == $doctor_busqueda;
                $especialidad_valido = empty($especialidad_busqueda) || $consulta['id_especialidad'] == $especialidad_busqueda;
                $fecha_valido = (empty($fecha_d) || $consulta['fecha'] >= $fecha_d) && (empty($fecha_h) || $consulta['fecha'] <= $fecha_h);

                if ($motivo_valido && $doctor_valido && $especialidad_valido && $fecha_valido) :
                  $consulta_id = $consulta['ID_Consulta'];
                  $result_estudios = $conexion->query("SELECT em.*, e.nombre as especialidad FROM estudios_medicos em JOIN especialidades e ON em.id_especialidad = e.id_especialidad WHERE ID_Consulta = $consulta_id");
              ?>
                  <div class="col-md-4 mb-3">
                    <div class="card">
                      <h5 class="card-header header-consulta"><?php echo ('#'. $consulta['ID_Consulta'] . ' - ' . $consulta['motivo']); ?></h5>
                      <div class="card-body">
                        <h5 class="card-title"><?php echo ($consulta['apellido_doctor'] . ' ' . $consulta['nombre_doctor']) . ' - ' . $consulta['especialidad']; ?></h5>
                        <p class="card-text"><?php echo ($consulta['fecha']); ?></p>
                        <a href="#" class="btn btn-primary ver-detalles"
                          data-motivo="<?php echo ($consulta['motivo']); ?>"
                          data-doctor="<?php echo ($consulta['apellido_doctor'] . ' ' . $consulta['nombre_doctor']); ?>"
                          data-especialidad="<?php echo ($consulta['especialidad']); ?>"
                          data-fecha="<?php echo ($consulta['fecha']); ?>"
                          data-diagnostico="<?php echo ($consulta['diagnostico']); ?>"
                          data-tratamiento="<?php echo ($consulta['tratamiento']); ?>"
                          data-comentarios="<?php echo ($consulta['comentarios']); ?>">Ver Detalles</a>
                      </div>
                    </div>
                  </div>
                  <?php
                  while ($estudio = $result_estudios->fetch_assoc()) :
                  ?>
                    <div class="col-md-4 mb-3">
                      <div class="card">
                        <h5 class="card-header header-estudio"><?php echo 'Estudio asociado a consulta: ' . ('#'. $consulta['ID_Consulta'] . ' - ' . $consulta['motivo']); ?></h5>
                        <div class="card-body">
                          <p class="card-text"><?php echo ($estudio['especialidad']) . ' - ' . ($estudio['Fecha']); ?></p>
                          <p class="card-text"><?php echo ($estudio['Informe']); ?></p>
                          <?php if (!empty($estudio['Imagenes'])) : ?>
                            <a href="<?php echo ($estudio['Imagenes']); ?>" target="_blank" class="btn btn-link">Ver Imagen</a>
                          <?php else : ?>
                            <a href="#" class="btn btn-link disabled" tabindex="-1" aria-disabled="true">No hay imagen asociada</a>
                          <?php endif; ?>

                        </div>
                      </div>
                    </div>
                  <?php
                  endwhile;
                  ?>
              <?php
                endif;
              endwhile; ?>
            </div>

          </div>




          <!-- Doctor -->
        <?php elseif ($tipo_usuario == 2) : ?>

          <!-- Menú de opciones -->
          <div class="col-lg-12 d-flex flex-column align-items-center">
            <ul class="nav nav-tabs mt-4" id="doctorTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="nueva-consulta-tab" data-bs-toggle="tab" data-bs-target="#nueva-consulta" type="button" role="tab" aria-controls="nueva-consulta" aria-selected="true">Registrar Nueva Consulta</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="nuevo-estudio-tab" data-bs-toggle="tab" data-bs-target="#nuevo-estudio" type="button" role="tab" aria-controls="nuevo-estudio" aria-selected="false">Registrar Nuevo Estudio</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="historial-tab" data-bs-toggle="tab" data-bs-target="#historial" type="button" role="tab" aria-controls="historial" aria-selected="false">Ver Historial de Paciente</button>
              </li>
            </ul>

            <!-- Contenido de las pestañas -->
            <div class="tab-content col-lg-8 mt-4 card p-4" id="doctorTabContent">

              <!-- Formulario de Nueva Consulta -->
              <div class="tab-pane fade show active" id="nueva-consulta" role="tabpanel" aria-labelledby="nueva-consulta-tab">
                <form id="form-nueva-consulta" method="POST" action="guardar_consulta.php">
                  <div class="mb-3">
                    <label for="motivo" class="form-label">Motivo de la Consulta</label>
                    <input type="text" class="form-control" id="motivo" name="motivo" required>
                  </div>
                  <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" required>
                  </div>
                  <div class="mb-3">
                    <label for="paciente" class="form-label">Seleccione el Paciente</label>
                    <select class="form-select" id="paciente" name="id_paciente" required>
                      <option value="">Seleccione un paciente</option>
                      <?php while ($paciente = $result_pacientes->fetch_assoc()) : ?>
                        <option value="<?php echo $paciente['ID_Paciente']; ?>">
                          <?php echo $paciente['nombre'] . ' ' . $paciente['apellido']; ?>
                        </option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="diagnostico" class="form-label">Diagnóstico</label>
                    <input type="text" class="form-control" id="diagnostico" name="diagnostico" required>
                  </div>
                  <div class="mb-3">
                    <label for="tratamiento" class="form-label">Tratamiento</label>
                    <input type="text" class="form-control" id="tratamiento" name="tratamiento" required>
                  </div>
                  <div class="mb-3">
                    <label for="comentarios" class="form-label">Comentarios</label>
                    <textarea class="form-control" id="comentarios" name="comentarios" rows="3"></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary">Registrar Consulta</button>
                </form>
              </div>

              <!-- Formulario de Nuevo Estudio -->
              <div class="tab-pane fade" id="nuevo-estudio" role="tabpanel" aria-labelledby="nuevo-estudio-tab">
                <form id="form-nuevo-estudio" method="POST" action="guardar_estudio.php" enctype="multipart/form-data">
                  <div class="mb-3">
                    <label for="id_consulta" class="form-label">ID de Consulta</label>
                    <input type="number" class="form-control" id="id_consulta" name="id_consulta" required>
                  </div>
                  <div class="mb-3">
                    <label for="id_especialidad" class="form-label">Especialidad</label>
                    <select class="form-select" id="id_especialidad" name="id_especialidad" required>
                      <option value="">Seleccione una especialidad</option>
                      <?php while ($especialidad = $result_especialidad->fetch_assoc()) : ?>
                        <option value="<?php echo $especialidad['ID_Especialidad']; ?>">
                          <?php echo $especialidad['nombre']; ?>
                        </option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="fecha_estudio" class="form-label">Fecha del Estudio</label>
                    <input type="date" class="form-control" id="fecha_estudio" name="fecha" required>
                  </div>
                  <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen</label>
                    <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                  </div>
                  <div class="mb-3">
                    <label for="informe" class="form-label">Informe</label>
                    <textarea class="form-control" id="informe" name="informe" rows="3" required></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary">Registrar Estudio</button>
                </form>
              </div>


              <!-- Historial del Paciente -->
              <div class="tab-pane fade" id="historial" role="tabpanel" aria-labelledby="historial-tab">
                <h5 class="mb-3">Historial de Paciente</h5>
                <form id="form-historial" method="POST" action="ver_historial.php">
                  <div class="mb-3">
                    <label for="paciente" class="form-label">Seleccione el Paciente</label>
                    <select class="form-select" id="paciente" name="id_paciente" required>
                      <option value="">Seleccione un paciente</option>
                      <?php while ($paciente = $historial_pacientes->fetch_assoc()) : ?>
                        <option value="<?php echo $paciente['ID_Paciente']; ?>">
                          <?php echo ($paciente['nombre'] . ' ' . $paciente['apellido']); ?>
                        </option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-primary">Ver Historial</button>
                </form>

                <!-- Mostrar resultados solo si hay historial disponible -->
                <?php if (!empty($historial_consultas) || !empty($historial_estudios)) : ?>
                  <div class="container mt-5">
                    <h3>Historial del Paciente</h3>

                    <!-- Sección de Consultas -->
                    <h4>Consultas</h4>
                    <div class="row col-md-12">
                      <?php if (is_array($historial_consultas) && count($historial_consultas) > 0): ?>
                        <?php foreach ($historial_consultas as $consulta): ?>
                          <div class="col-md-4 mb-3">
                            <div class="card">
                              <h5 class="card-header header-consulta"><?php echo '#' . ($consulta['id_consulta']) . ' - ' .($consulta['motivo']); ?></h5>
                              <div class="card-body">
                                <h5 class="card-title"><?php echo ($consulta['diagnostico']); ?></h5>
                                <p class="card-text">
                                  <strong>Fecha:</strong> <?php echo ($consulta['fecha']); ?><br>
                                  <strong>Tratamiento:</strong> <?php echo ($consulta['tratamiento']); ?><br>
                                  <strong>Comentarios:</strong> <?php echo ($consulta['comentarios']); ?>
                                </p>
                                <a href="#" class="btn btn-primary ver-detalles"
                                  data-motivo="<?php echo ($consulta['motivo']); ?>"
                                  data-doctor="<?php echo ($consulta['apellido_doctor'] . ' ' . $consulta['nombre_doctor']); ?>"
                                  data-especialidad="<?php echo ($consulta['especialidad']); ?>"
                                  data-fecha="<?php echo ($consulta['fecha']); ?>"
                                  data-diagnostico="<?php echo ($consulta['diagnostico']); ?>"
                                  data-tratamiento="<?php echo ($consulta['tratamiento']); ?>"
                                  data-comentarios="<?php echo ($consulta['comentarios']); ?>">Ver Detalles</a>
                              </div>
                            </div>
                          </div>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <p>No hay consultas registradas para este paciente.</p>
                      <?php endif; ?>
                    </div>

                    <!-- Sección de Estudios Médicos -->
                    <h4>Estudios Médicos</h4>
                    <div class="row col-md-12">
                      <?php if (is_array($historial_estudios) && count($historial_estudios) > 0): ?>
                        <?php foreach ($historial_estudios as $estudio): ?>
                          <div class="col-md-4 mb-3">
                            <div class="card">
                              <h5 class="card-header header-estudio"><?php echo 'Estudio asociado a consulta: ' . ('#'. $estudio['id_consulta'] . ' - ' . $estudio['motivo']); ?></h5>
                              
                              <div class="card-body">
                                <p class="card-text">
                                  <strong>Especialidad:</strong> <?php echo ($estudio['especialidad']); ?><br>
                                  <strong>Fecha:</strong> <?php echo ($estudio['Fecha']); ?><br>
                                  <strong>Informe:</strong> <?php echo ($estudio['Informe']); ?><br>
                                  <strong>Imagen:</strong>
                                  <?php if (!empty($estudio['Imagenes'])): ?>
                                    <a href="<?php echo ($estudio['Imagenes']); ?>" target="_blank">Ver Imagen</a>
                                  <?php else: ?>
                                    Sin imagen
                                  <?php endif; ?>
                                </p>
                              </div>
                            </div>
                          </div>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <p>No hay estudios registrados para este paciente.</p>
                      <?php endif; ?>
                    </div>
                  </div>
                <?php endif; ?>
              </div>




            </div>
          </div>

        <?php endif; ?>

      </div>

    </section>

  </main>


  <footer class="footer light-background">
    <div class="container copyright text-center">
      <p>© 2024 <strong class="px-1 sitename">Historia Clinica Digital</strong> <span>Todos los derechos reservados </span></p>
    </div>
  </footer>

  <!-- Modal Detalle -->
  <div class="modal fade" id="consultaModal" tabindex="-1" aria-labelledby="consultaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="consultaModalLabel">Detalles de la Consulta</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table class="table">
            <tbody>
              <tr>
                <th>Motivo</th>
                <td id="modal-motivo"></td>
              </tr>
              <tr>
                <th>Doctor</th>
                <td id="modal-doctor"></td>
              </tr>
              <tr>
                <th>Especialidad</th>
                <td id="modal-especialidad"></td>
              </tr>
              <tr>
                <th>Fecha</th>
                <td id="modal-fecha"></td>
              </tr>
              <tr>
                <th>Diagnóstico</th>
                <td id="modal-diagnostico"></td>
              </tr>
              <tr>
                <th>Tratamiento</th>
                <td id="modal-tratamiento"></td>
              </tr>
              <tr>
                <th>Comentarios</th>
                <td id="modal-comentarios"></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Resultado Consulta-->
  <div class="modal fade" id="resultadoModal" tabindex="-1" aria-labelledby="resultadoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="resultadoModalLabel">Resultado</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p id="mensajeResultado"><?php echo $consulta_result; ?></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>




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

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const botonesDetalles = document.querySelectorAll('.ver-detalles');

      botonesDetalles.forEach(boton => {
        boton.addEventListener('click', function(event) {
          event.preventDefault();

          // Obtener los datos del botón
          const motivo = this.getAttribute('data-motivo');
          const doctor = this.getAttribute('data-doctor');
          const especialidad = this.getAttribute('data-especialidad');
          const fecha = this.getAttribute('data-fecha');
          const diagnostico = this.getAttribute('data-diagnostico');
          const tratamiento = this.getAttribute('data-tratamiento');
          const comentarios = this.getAttribute('data-comentarios');

          // Asignar los datos al modal
          document.getElementById('modal-motivo').textContent = motivo;
          document.getElementById('modal-doctor').textContent = doctor;
          document.getElementById('modal-especialidad').textContent = especialidad;
          document.getElementById('modal-fecha').textContent = fecha;
          document.getElementById('modal-diagnostico').textContent = diagnostico;
          document.getElementById('modal-tratamiento').textContent = tratamiento;
          document.getElementById('modal-comentarios').textContent = comentarios;

          // Abrir el modal
          const modal = new bootstrap.Modal(document.getElementById('consultaModal'));
          modal.show();
        });
      });
    });
  </script>

  <script>
    // Mostrar el modal si hay un resultado de la consulta
    document.addEventListener('DOMContentLoaded', function() {
      <?php if (!empty($consulta_result)) : ?>
        var myModal = new bootstrap.Modal(document.getElementById('resultadoModal'));
        myModal.show();
      <?php endif; ?>
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Verificar si la pestaña activa debe ser 'historial'
      var tabActiva = "<?php echo $tab_activa; ?>";
      if (tabActiva === "historial") {
        var historialTab = new bootstrap.Tab(document.getElementById('historial-tab'));
        historialTab.show();
      }
    });
  </script>


</body>

</html>

<?php
$conexion->close();
?>