<?php
include '../includes/header.php';
require_once '../includes/db.php';
//session_start();

// Verifica si el usuario es administrador
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    die("Acceso denegado.");
}

// Cambios de estado (GET)
if (isset($_GET['accion'], $_GET['id'])) {
    $id = intval($_GET['id']);
    $accion = $_GET['accion'] === 'aceptar' ? 'admitida' : 'rechazada';
    $stmt = $conn->prepare("UPDATE fotografias SET estado = ? WHERE id = ?");
    $stmt->bind_param("si", $accion, $id);
    $stmt->execute();
}

// Obtener fotos pendientes
$sql = "SELECT f.id, f.titulo, f.descripcion, f.archivo, u.nombre 
        FROM fotografias f
        JOIN usuarios u ON f.id_usuario = u.id
        WHERE f.estado = 'pendiente'";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validar Fotos - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<main class="form-container">
    <h2>Validar Fotografías Pendientes</h2>

    <?php if ($resultado->num_rows > 0): ?>
        <?php while ($foto = $resultado->fetch_assoc()): ?>
            <div style="margin-bottom: 2rem; text-align:center;">
                <img src="../uploads/<?= htmlspecialchars($foto['archivo']) ?>" style="max-width: 100%; height: auto; border-radius: 8px;">
                <h3><?= htmlspecialchars($foto['titulo']) ?></h3>
                <p>Autor: <?= htmlspecialchars($foto['nombre']) ?></p>
                <p><?= htmlspecialchars($foto['descripcion']) ?></p>
                <a href="?accion=aceptar&id=<?= $foto['id'] ?>" class="btn">✅ Aceptar</a>
                <a href="?accion=rechazar&id=<?= $foto['id'] ?>" class="btn" style="background-color:#b71c1c;">❌ Rechazar</a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No hay fotografías pendientes por validar.</p>
    <?php endif; ?>
</main>
</body>
</html>
