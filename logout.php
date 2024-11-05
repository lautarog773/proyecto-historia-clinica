<?php
session_start();
session_destroy(); // Destruye todas las sesiones activas
header("Location: form_login.php"); // Redirige al login
exit();
?>
