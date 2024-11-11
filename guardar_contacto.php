<?php
header('Content-Type: application/json');

try {
    include 'conexion.php';

    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        $query = $conexion->prepare("INSERT INTO contactos (Nombre, Mail, Asunto, Mensaje) VALUES (?, ?, ?, ?)");
        $query->bind_param("ssss", $name, $email, $subject, $message);
        $query->execute();
    }

    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
