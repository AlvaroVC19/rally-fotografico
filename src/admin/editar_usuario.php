<?php
session_start();
require_once '../includes/db.php';

// Verificar que sea admin
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    header("Location: /rally-fotografico/src/index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir y sanitizar datos
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $rol = $_POST['rol'] ?? '';

    // Validar datos básicos
    if (!$id || empty($nombre) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || !in_array($rol, ['participante', 'admin'])) {
        $_SESSION['mensaje_error'] = "Datos inválidos, inténtalo de nuevo.";
        header("Location: editar_usuario_html.php?id=" . urlencode($id));
        exit();
    }

    // Actualizar en la BD
    $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, email = ?, rol = ? WHERE id = ?");
    $stmt->bind_param("sssi", $nombre, $email, $rol, $id);

    if ($stmt->execute()) {
        $_SESSION['mensaje_exito'] = "Usuario actualizado correctamente.";
        header("Location: usuarios_html.php");
        exit();
    } else {
        $_SESSION['mensaje_error'] = "Error al actualizar usuario.";
        header("Location: editar_usuario_html.php?id=" . urlencode($id));
        exit();
    }
} else {
    // Si no es POST, redirige
    header("Location: usuarios_html.php");
    exit();
}
