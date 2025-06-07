<?php
include '../includes/header.php';
require_once '../includes/db.php';

// Verificar sesión activa
if (!isset($_SESSION["id"])) {
    header("Location: login_html.php");
    exit;
}

$id_usuario = $_SESSION["id"];
$nombre = $_SESSION["nombre"];

// Obtener fotos del usuario
$stmt = $conn->prepare("SELECT id, titulo, archivo, estado FROM fotografias WHERE id_usuario = ?");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$fotos = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de <?= htmlspecialchars($nombre) ?> - FlorClick 2025</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<main class="galeria-main" style="background-image: url('images/fondo.jpg');">
    <h2>Perfil de <?= htmlspecialchars($nombre) ?></h2>

    <div style="display: flex; justify-content: center; gap: 1rem; margin: 1rem 0;">
        <button onclick="location.href='subir_foto_html.php'" class="btn">Subir nueva foto</button>
        <button onclick="location.href='/rally-fotografico/src/participantes/registro_html.php'" class="btn">Editar datos</button>
    </div>

    <?php if ($fotos->num_rows > 0): ?>
        <div class="galeria-grid">
            <?php while ($foto = $fotos->fetch_assoc()): ?>
                <div class="foto-card">
                    <img src="../uploads/<?= htmlspecialchars($foto['archivo']) ?>" alt="Foto subida" class="foto-img">
                    <h3><?= htmlspecialchars($foto['titulo']) ?></h3>
                    <p>
                        Estado:
                        <?php
                        echo match($foto['estado']) {
                            'pendiente' => '<span style="color: orange;">Pendiente</span>',
                            'admitida' => '<span style="color: green;">Admitida</span>',
                            'rechazada' => '<span style="color: red;">Rechazada</span>',
                            default => 'Desconocido'
                        };
                        ?>
                    </p>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p style="text-align:center;">Aún no has subido ninguna fotografía.</p>
    <?php endif; ?>
</main>
</body>
</html>
