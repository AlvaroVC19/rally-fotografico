<?php
session_start();
require_once '../includes/db.php';

// Verificar que sea admin
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    header("Location: /rally-fotografico/src/index.php");
    exit();
}

// Obtener ID usuario a editar por GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: usuarios_html.php");
    exit();
}

$id_usuario = (int)$_GET['id'];

// Obtener datos del usuario desde DB
$stmt = $conn->prepare("SELECT id, nombre, email, rol FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Usuario no encontrado
    header("Location: usuarios_html.php");
    exit();
}

$usuario = $result->fetch_assoc();

include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario - Rally de Flores</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<main class="form-container">
    <h2>Editar Usuario: <?= htmlspecialchars($usuario['nombre']) ?></h2>

    <form action="editar_usuario.php" method="post">
        <input type="hidden" name="id" value="<?= $usuario['id'] ?>">

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>

        <label for="rol">Rol:</label>
        <select id="rol" name="rol" required>
            <option value="participante" <?= $usuario['rol'] === 'participante' ? 'selected' : '' ?>>Participante</option>
            <option value="admin" <?= $usuario['rol'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
        </select>

        <input type="submit" value="Guardar Cambios">
    </form>
</main>
</body>
</html>
