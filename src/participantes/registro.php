<?php
session_start();
require_once '../includes/db.php';

$esEdicion = isset($_SESSION["id"]);
$id_usuario = $esEdicion ? $_SESSION["id"] : null;

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: registro_html.php");
    exit;
}

$nombre = trim($_POST["nombre"]);
$email = trim($_POST["email"]);
$password = $_POST["password"];
$confirmar = $_POST["confirmar"];

// Validar contraseñas (para registro obligatorio, para edición solo si cambia)
if (($esEdicion && ($password !== "" || $confirmar !== "")) || !$esEdicion) {
    if ($password !== $confirmar) {
        echo "Las contraseñas no coinciden.";
        exit;
    }
}

// Verificar email ya usado por otro usuario (en edición se ignora el propio)
if ($esEdicion) {
    $sql = "SELECT id FROM usuarios WHERE email = ? AND id != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $email, $id_usuario);
} else {
    $sql = "SELECT id FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
}
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "El correo ya está registrado.";
    exit;
}

if ($esEdicion) {
    // Actualizar usuario
    if ($password !== "") {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET nombre = ?, email = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nombre, $email, $hash, $id_usuario);
    } else {
        $sql = "UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $nombre, $email, $id_usuario);
    }

    if ($stmt->execute()) {
        $_SESSION["nombre"] = $nombre;
        header("Location: perfil_html.php?editado=ok");
        exit;
    } else {
        echo "Error al actualizar los datos: " . $stmt->error;
    }
} else {
    // Registrar nuevo usuario
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
