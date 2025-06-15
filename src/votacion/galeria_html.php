<?php
session_start();
include '../includes/header.php'; 
require_once '../includes/db.php';

// Obtener todas las fotos admitidas, ordenadas por votos
$sql = "SELECT f.id, f.titulo, f.descripcion, f.archivo, u.nombre, f.id_usuario,
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
<main class="galeria-main">
    <h2>📸 Galería de Fotos Admitidas</h2>

    <!-- Mensajes de votación -->
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

    <!-- Fotos -->
    <?php if ($resultado->num_rows > 0): ?>
        <div class="galeria-grid">
            <?php while ($foto = $resultado->fetch_assoc()): ?>
                <div class="foto-card">
                    <img src="../uploads/<?= htmlspecialchars($foto['archivo']) ?>" alt="Foto" class="foto-img">
                    <h3><?= htmlspecialchars($foto['titulo']) ?></h3>
                    <?php
                        $desc = trim($foto['descripcion'] ?? '');
                        if ($desc === '') {
                            // No hay descripción, mostramos mensaje en gris claro e itálica
                            echo '<p><span style="color: #aaa; font-style: italic;">(Sin descripción)</span></p>';
                        } else {
                            // Hay descripción, la mostramos normal
                            echo '<p>' . htmlspecialchars($desc) . '</p>';
                        }
                    ?>
                    <p>Autor: <?= htmlspecialchars($foto['nombre']) ?></p>
                    <p>Votos: <?= $foto['votos'] ?></p>

                    <?php
                    $id_votante = $_SESSION["id"] ?? null;
                    if (!$id_votante || intval($id_votante) !== intval($foto['id_usuario'])):
                    ?>
                        <form action="votar.php" method="POST">
                            <input type="hidden" name="id_foto" value="<?= $foto['id'] ?>">
                            <input type="submit" value="🗳️ Votar esta foto" class="btn">
                        </form>
                    <?php else: ?>
                        <p style="color: #888; font-style: italic;">No puedes votar tu propia foto.</p>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>No hay fotos admitidas por el momento.</p>
    <?php endif; ?>
</main>
<?php include '../includes/footer.php'; ?>
</body>
</html>
