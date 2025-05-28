<?php 
include '../includes/header.php'; 
require_once '../includes/db.php';
//session_start();

// Obtener todas las fotos admitidas, ordenadas por votos
$sql = "SELECT f.id, f.titulo, f.archivo, u.nombre, f.id_usuario,
               (SELECT COUNT(*) FROM votos WHERE id_foto = f.id) AS votos
        FROM fotografias f
        JOIN usuarios u ON f.id_usuario = u.id
        WHERE f.estado = 'admitida'
        ORDER BY votos DESC";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Galería - Rally de Flores</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<main class="form-container">
    <h2>Galería de Fotos Admitidas</h2>

    <!-- Mensaje emergente -->
    <?php if (isset($_GET["voto"])): ?>
        <div class="mensaje <?= htmlspecialchars($_GET["voto"]) ?>">
            <?php if ($_GET["voto"] === "ok"): ?>
                ✅ ¡Tu voto ha sido registrado correctamente!
            <?php elseif ($_GET["voto"] === "duplicado"): ?>
                ⚠️ Ya has votado esta fotografía desde esta IP.
            <?php elseif ($_GET["voto"] === "autovoto"): ?>
                ❌ No puedes votar tu propia fotografía.
            <?php elseif ($_GET["voto"] === "fuera_fecha"): ?>
                ⏳ El período de votación no está activo en este momento.
            <?php else: ?>
                ❌ Hubo un error al registrar tu voto.
            <?php endif; ?>
        </div>
    <?php endif; ?>


    <!-- Galería -->
    <?php while ($foto = $resultado->fetch_assoc()): ?>
        <div style="margin-bottom: 2rem; text-align:center;">
            <img src="../uploads/<?= htmlspecialchars($foto['archivo']) ?>" 
                 style="max-width: 100%; height: auto; border-radius: 8px;">
            <h3><?= htmlspecialchars($foto['titulo']) ?></h3>
            <p>Autor: <?= htmlspecialchars($foto['nombre']) ?></p>
            <p>Votos: <?= $foto['votos'] ?></p>

            <?php 
            // Mostrar botón de votar solo si el usuario no es el autor (si está logueado)
            $id_votante = $_SESSION["id"] ?? null;
            if (!$id_votante || intval($id_votante) !== intval($foto['id_usuario'])): 
            ?>
                <form action="votar.php" method="POST">
                    <input type="hidden" name="id_foto" value="<?= $foto['id'] ?>">
                    <input type="submit" value="🗳️ Votar esta foto" class="btn">
                </form>
            <?php else: ?>
                <p style="color: #999; font-style: italic;">No puedes votar tu propia foto.</p>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
</main>
</body>
</html>
