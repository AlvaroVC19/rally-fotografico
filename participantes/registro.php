<?php
require_once '../includes/db.php';
include '../includes/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirmar = $_POST["confirmar"];

    // Validar contraseña
    if ($password !== $confirmar) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    // Verificar si ya existe el correo
    $sql = "SELECT id FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "El correo ya está registrado.";
        exit;
    }

    // Insertar nuevo usuario
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, 'participante')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nombre, $email, $hash);

    if ($stmt->execute()) {
        header("Location: login_html.php?registro=ok");
        exit;
    } else {
        echo "Error al registrar: " . $stmt->error;
    }
}
?>
